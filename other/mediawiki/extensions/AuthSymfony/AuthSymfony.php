<?php
 
if(!defined( 'MEDIAWIKI' ))
{
  die('Not a valid entry point.');
}
 
$wgExtensionCredits['other'][] = array(
  'name' => 'AuthSymfony',
  'author' => 'Alex Grintsvayg (alex@flickswitch.cc)',
  'url' => 'http://www.mediawiki.org/wiki/Extension:AuthSymfony',
  'description' => 'Allows MediaWiki to be integrated into a Symfony application.'
);
 
 
if (!class_exists('AuthPlugin'))
{
  require_once "{$GLOBALS['IP']}/includes/AuthPlugin.php";
}
 
 
class AuthSymfony extends AuthPlugin
{
                   // Database access
  protected static $useExtDbKey = 'wgAuthSymfony_useExtDb',
                   $hostKey = 'wgAuthSymfony_host',
                   $usernameKey = 'wgAuthSymfony_username',
                   $passwordKey = 'wgAuthSymfony_password',
                   $databaseKey = 'wgAuthSymfony_database',
 
                   // Credentials
                   $loginCredentialKey = 'wgAuthSymfony_login_credential',
                   $editorCredentialKey = 'wgAuthSymfony_editor_credential',
                   $sysopCredentialKey = 'wgAuthSymfony_sysop_credential',
 
                   // Tables
                   $userTable = 'sf_guard_user',
                   $userPermissionTable = 'sf_guard_user_permission',
                   $permissionTable = 'sf_guard_permission',
                   $userGroupTable = 'sf_guard_user_group',
                   $groupPermissionTable = 'sf_guard_group_permission',
 
                   // Login columns
                   $usernameCol = 'username',
                   $passwordCol = 'password',
                   $algorithm = 'sha1',
                   $algorithmCol = 'algorithm',
                   $salt = null,
                   $saltCol = 'salt'
                   ;
 
  protected function getConnection()
  {
    if ($GLOBALS[static::$useExtDbKey] == true)
    {
      $host = $GLOBALS[static::$hostKey];
      $username = $GLOBALS[static::$usernameKey];
      $password = $GLOBALS[static::$passwordKey];
      $database = $GLOBALS[static::$databaseKey];
    }
    else
    {
      $host = $GLOBALS['wgDBserver'];
      $username = $GLOBALS['wgDBuser'];
      $password = $GLOBALS['wgDBpassword'];
      $database = $GLOBALS['wgDBname'];
    }
 
    $connection = mysql_connect($host, $username, $password);
    if (!$connection)
    {
      $this->mySQLError('There was a problem when connecting to the Symfony database. ' .
        'Check your host, username, and password settings.');
    }
 
    $db = mysql_select_db($database, $connection);
    if (!$db)
    {
      $this->mySQLError('There was a problem when connecting to the SMF database. ' .
        'The database ' . $database . ' was not found.');
    }
 
    return $connection;
  }
 
  public function getUser($username)
  {
    $conn = $this->getConnection();
 
    $query = sprintf('SELECT * FROM `%s` WHERE `%s` = "%s" LIMIT 1',
        static::$userTable, static::$usernameCol, $username);
 
    $result = mysql_query($query, $conn) or die($this->mySQLError('Unable to query external table'));
    return mysql_fetch_array($result);
  }
 
  /**
   * Check whether there exists a user account with the given name.
   * The name will be normalized to MediaWiki's requirements, so
   * you might need to munge it (for instance, for lowercase initial
   * letters).
   *
   * @param $username String: username.
   * @return bool
   */
  public function userExists($username)
  {
    $user = $this->getUser($username);
 
    // Doublecheck
    if ($user &&
      htmlentities(strtolower($username), ENT_QUOTES, 'UTF-8') ==
      htmlentities(strtolower($user[static::$usernameCol]), ENT_QUOTES, 'UTF-8'))
    {
      return true;
    }
 
    return false;
  }
 
  /**
   * Check if a username+password pair is a valid login.
   * The name will be normalized to MediaWiki's requirements, so
   * you might need to munge it (for instance, for lowercase initial
   * letters).
   *
   * @param $username String: username.
   * @param $password String: user password.
   * @return bool
   */
  public function authenticate($username, $password)
  {
    $user = $this->getUser($username);
 
    if ($user)
    {
      $algorithm = static::$algorithmCol ? $user[static::$algorithmCol] : static::$algorithm;
      $salt = static::$saltCol ? $user[static::$saltCol] : static::$salt;
 
      return $algorithm($salt . $password) == $user[static::$passwordCol]
             &&
             $this->hasLoginCredential($user['username']);
    }
 
    return false;
  }
 
  protected function hasLoginCredential($username)
  {
    return !(isset($GLOBALS[static::$loginCredentialKey]) && $GLOBALS[static::$loginCredentialKey])
           ||
           $this->hasCredential($username, $GLOBALS[static::$loginCredentialKey]);
  }
 
  protected function hasEditorCredential($username)
  {
    return !(isset($GLOBALS[static::$editorCredentialKey]) && $GLOBALS[static::$editorCredentialKey])
           ||
           $this->hasCredential($username, $GLOBALS[static::$editorCredentialKey]);
  }
 
  protected function hasSysopCredential($username)
  {
    return !(isset($GLOBALS[static::$sysopCredentialKey]) && $GLOBALS[static::$sysopCredentialKey])
           ||
           $this->hasCredential($username, $GLOBALS[static::$sysopCredentialKey]);
  }
 
  protected function hasCredential($username, $credential)
  {
    $conn = $this->getConnection();
 
    $query = sprintf('SELECT * 
                      FROM `%s` AS u
                      LEFT JOIN `%s` up ON u.id = up.user_id
                      LEFT JOIN `%s` p ON up.permission_id = p.id
                      WHERE u.username = "%s" AND p.name = "%s"
                      LIMIT 1',
        static::$userTable, static::$userPermissionTable, static::$permissionTable, $username, $credential);
 
    $result = mysql_query($query, $conn) or die($this->mySQLError('Unable to query external table'));
 
    // If user has direct permission, return true
    if (mysql_fetch_array($result))
    {
      return true;
    }
 
    // Otherwise, check for group permissions
    $query = sprintf('SELECT *
                      FROM `%s` AS u
                      LEFT JOIN `%s` ug ON u.id = ug.user_id
                      LEFT JOIN `%s` gp ON ug.group_id = gp.group_id
                      LEFT JOIN `%s` p ON gp.permission_id = p.id
                      WHERE u.username = "%s" AND p.name = "%s"
                      LIMIT 1',
        static::$userTable, static::$userGroupTable, static::$groupPermissionTable, static::$permissionTable, $username, $credential);
 
    $result = mysql_query($query, $conn) or die($this->mySQLError('Unable to query external table'));
 
    return !!mysql_fetch_array($result);
  }
 
  /**
   * When creating a user account, optionally fill in preferences and such.
   * For instance, you might pull the email address or real name from the
   * external user database.
   *
   * The User object is passed by reference so it can be modified; don't
   * forget the & on your function declaration.
   *
   * @param $user User object.
   * @param $autocreate Boolean: True if user is being autocreated on login
   */
  public function initUser(&$user, $autocreate=false)
  {
    # Override this to do something.
  }
 
  function mySQLError($message)
  {
    echo $message . '<br />';
    echo 'MySQL Error Number: ' . mysql_errno() . '<br />';
    echo 'MySQL Error Message: ' . mysql_error() . '<br /><br />';
    exit;
  }
//      /**
//       * Allow a property change? Properties are the same as preferences
//       * and use the same keys. 'Realname' 'Emailaddress' and 'Nickname'
//       * all reference this.
//       *
//       * @return Boolean
//       */
//      public function allowPropChange( $prop = '' ) {
//              if( $prop == 'realname' && is_callable( array( $this, 'allowRealNameChange' ) ) ) {
//                      return $this->allowRealNameChange();
//              } elseif( $prop == 'emailaddress' && is_callable( array( $this, 'allowEmailChange' ) ) ) {
//                      return $this->allowEmailChange();
//              } elseif( $prop == 'nickname' && is_callable( array( $this, 'allowNickChange' ) ) ) {
//                      return $this->allowNickChange();
//              } else {
//                      return true;
//              }
//      }
 
  /**
   * Add a user to the external authentication database.
   * Return true if successful.
   *
   * We will never do this, so always return false.
   *
   * @param $user User: only the name should be assumed valid at this point
   * @param $password String
   * @param $email String
   * @param $realname String
   * @return Boolean
   */
  public function addUser($user, $password, $email='', $realname='')
  {
    return false;
  }
 
  /**
   * When a user logs in, optionally fill in preferences and such.
   * For instance, you might pull the email address or real name from the
   * external user database.
   *
   * The User object is passed by reference so it can be modified; don't
   * forget the & on your function declaration.
   *
   * @param $user User object
   */
  public function updateUser(&$user)
  {
    $user->loadGroups();
    if ($this->hasSysopCredential($user->mName))
    {
      $user->addGroup('sysop');
    }
    else if (in_array('sysop', $user->mGroups))
    {
      $user->removeGroup('sysop');
    }
 
    if ($this->hasEditorCredential($user->mName))
    {
      $user->addGroup('editor');
    }
    else if (in_array('editor', $user->mGroups))
    {
      $user->removeGroup('editor');
    }
 
    return true;
  }
 
  /**
   * Modify options in the login template.
   *
   * Disable any account management options. Symfony should handle all of this.
   *
   * @param $template UserLoginTemplate object.
   * @param $type String 'signup' or 'login'.
   */
  public function modifyUITemplate(&$template, &$type)
  {
    $template->set('usedomain', false); // We do not want a domain name.
    $template->set('create', false); // Remove option to create new accounts from the wiki.
    $template->set('useemail', false); // Disable the mail new password box.
  }
 
  /**
   * Return true if the wiki should create a new local account automatically
   * when asked to login a user who doesn't exist locally but does in the
   * external auth database.
   *
   * If you don't automatically create accounts, you must still create
   * accounts in some way. It's not possible to authenticate without
   * a local account.
   *
   * This is just a question, and shouldn't perform any actions.
   *
   * @return Boolean
   */
  public function autoCreate()
  {
    return true;
  }
 
  /**
   * Check to see if the specific domain is a valid domain.
   *
   * @param $domain String: authentication domain.
   * @return bool
   */
  public function validDomain($domain)
  {
    return true;
  }
 
  /**
   * Can users change their passwords?
   *
   * No, only in Symfony.
   *
   * @return bool
   */
  public function allowPasswordChange()
  {
    return false;
  }
 
  /**
   * Set the given password in the authentication database.
   * As a special case, the password may be set to null to request
   * locking the password to an unusable value, with the expectation
   * that it will be set later through a mail reset or other method.
   *
   * Return true if successful.
   *
   * DO NOTHING. Symony should do all of this.
   *
   * @param $user User object.
   * @param $password String: password.
   * @return bool
   */
  public function setPassword($user, $password)
  {
    return true;
  }
 
  /**
   * Check to see if external accounts can be created.
   * Return true if external accounts can be created.
   *
   * Account must be created in Symfony, so always return false.
   *
   * @return Boolean
   */
  public function canCreateAccounts()
  {
    return false;
  }
 
  /**
   * Return true to prevent logins that don't authenticate here from being
   * checked against the local database's password fields.
   *
   * This is just a question, and shouldn't perform any actions.
   *
   * @return Boolean
   */
  public function strict()
  {
    return true;
  }
 
  /**
   * Update user information in the external authentication database.
   * Return true if successful.
   *
   * Does nothing. This extension is a one-way street.
   *
   * @param $user User object.
   * @return Boolean
   */
  public function updateExternalDB($user)
  {
    return true;
  }
}