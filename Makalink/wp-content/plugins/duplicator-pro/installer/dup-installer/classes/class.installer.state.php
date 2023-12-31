<?php

defined("DUPXABSPATH") or die("");

use Duplicator\Installer\Core\Deploy\ServerConfigs;
use Duplicator\Installer\Core\Security;
use Duplicator\Installer\Utils\Log\Log;
use Duplicator\Installer\Core\Params\Descriptors\ParamDescConfigs;
use Duplicator\Installer\Core\Params\PrmMng;
use Duplicator\Installer\Utils\InstallerOrigFileMng;
use Duplicator\Libs\Snap\SnapIO;

class DUPX_InstallerState
{
    /**
     * modes
     */
    const MODE_UNKNOWN     = -1;
    const MODE_STD_INSTALL = 0;
    const MODE_OVR_INSTALL = 1;

    /**
     * install types
     */
    const INSTALL_NOT_SET                      = -2;
    const INSTALL_SINGLE_SITE                  = -1;
    const INSTALL_STANDALONE                   = 0;
    const INSTALL_MULTISITE_SUBDOMAIN          = 2;
    const INSTALL_MULTISITE_SUBFOLDER          = 3;
    const INSTALL_SINGLE_SITE_ON_SUBDOMAIN     = 4;
    const INSTALL_SINGLE_SITE_ON_SUBFOLDER     = 5;
    const INSTALL_SUBSITE_ON_SUBDOMAIN         = 6;
    const INSTALL_SUBSITE_ON_SUBFOLDER         = 7;
    const INSTALL_RBACKUP_SINGLE_SITE          = 8;
    const INSTALL_RBACKUP_MULTISITE_SUBDOMAIN  = 9;
    const INSTALL_RBACKUP_MULTISITE_SUBFOLDER  = 10;
    const INSTALL_RECOVERY_SINGLE_SITE         = 11;
    const INSTALL_RECOVERY_MULTISITE_SUBDOMAIN = 12;
    const INSTALL_RECOVERY_MULTISITE_SUBFOLDER = 13;

    const SUBSITE_IMPORT_WP_MIN_VERSION = '4.6';

    /** @var int */
    protected $mode = self::MODE_UNKNOWN;
    /** @var string */
    protected $ovr_wp_content_dir = '';
    /** @var ?self */
    private static $instance = null;

    /**
     * Get instance
     *
     * @return self
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Class constructor
     */
    private function __construct()
    {
    }

    /**
     * return installer mode
     *
     * @return int
     */
    public function getMode()
    {
        return PrmMng::getInstance()->getValue(PrmMng::PARAM_INSTALLER_MODE);
    }

    /**
     * check current installer mode
     *
     * @param bool $onlyIfUnknown check se state only if is unknow state
     * @param bool $saveParams    if true update params
     *
     * @return boolean
     */
    public function checkState($onlyIfUnknown = true, $saveParams = true)
    {
        $paramsManager = PrmMng::getInstance();

        if ($onlyIfUnknown && $paramsManager->getValue(PrmMng::PARAM_INSTALLER_MODE) !== self::MODE_UNKNOWN) {
            return true;
        }
        $isOverwrite   = false;
        $overwriteData = false;
        $nManager      = DUPX_NOTICE_MANAGER::getInstance();
        try {
            if (self::isImportFromBackendMode() || self::isRecoveryMode()) {
                $overwriteData = $this->getOverwriteDataFromParams();
            } else {
                $overwriteData = $this->getOverwriteDataFromWpConfig();
            }

            if (!empty($overwriteData)) {
                if (!DUPX_DB::testConnection($overwriteData['dbhost'], $overwriteData['dbuser'], $overwriteData['dbpass'], $overwriteData['dbname'])) {
                    throw new Exception('wp-config.php exists but database data connection isn\'t valid. Continuing with standard install');
                }

                $isOverwrite = true;

                if (!self::isImportFromBackendMode() && !self::isRecoveryMode()) {
                    //Add additional overwrite data for standard installs
                    $overwriteData['adminUsers'] = $this->getAdminUsersOnOverwriteDatabase($overwriteData);
                    $overwriteData['dupVersion'] = $this->getDuplicatorVersionOverwrite($overwriteData);
                    $overwriteData['wpVersion']  = $this->getWordPressVersionOverwrite();
                }
            }
        } catch (Exception $e) {
            Log::logException($e);
            $longMsg = "Exception message: " . $e->getMessage() . "\n\n";
            $nManager->addNextStepNotice(array(
                'shortMsg'    => 'wp-config.php exists but isn\'t valid. Continue on standard install.',
                'level'       => DUPX_NOTICE_ITEM::SOFT_WARNING,
                'longMsg'     => $longMsg,
                'longMsgMode' => DUPX_NOTICE_ITEM::MSG_MODE_PRE
            ));
            $nManager->saveNotices();
        } catch (Error $e) {
            Log::logException($e);
            $longMsg = "Exception message: " . $e->getMessage() . "\n\n";
            $nManager->addNextStepNotice(array(
                'shortMsg'    => 'wp-config.php exists but isn\'t valid. Continue on standard install.',
                'level'       => DUPX_NOTICE_ITEM::SOFT_WARNING,
                'longMsg'     => $longMsg,
                'longMsgMode' => DUPX_NOTICE_ITEM::MSG_MODE_PRE
            ));
            $nManager->saveNotices();
        }


        if ($isOverwrite) {
            $paramsManager->setValue(PrmMng::PARAM_INSTALLER_MODE, self::MODE_OVR_INSTALL);
            $paramsManager->setValue(PrmMng::PARAM_OVERWRITE_SITE_DATA, $overwriteData);
        } else {
            $paramsManager->setValue(PrmMng::PARAM_INSTALLER_MODE, self::MODE_STD_INSTALL);
        }

        if ($saveParams) {
            return $this->save();
        } else {
            return true;
        }
    }

    /**
     *
     * @param int $type
     *
     * @return string
     */
    public static function installTypeToString($type = null)
    {
        if (is_null($type)) {
            $type = self::getInstType();
        }
        switch ($type) {
            case self::INSTALL_MULTISITE_SUBDOMAIN:
                return 'multisite subdomain';
            case self::INSTALL_MULTISITE_SUBFOLDER:
                return 'multisite subfolder';
            case self::INSTALL_STANDALONE:
                return 'standalone subsite';
            case self::INSTALL_SUBSITE_ON_SUBDOMAIN:
                return 'subsite on subdomain multisite';
            case self::INSTALL_SUBSITE_ON_SUBFOLDER:
                return 'subsite on subfolder multisite';
            case self::INSTALL_SINGLE_SITE:
                return 'single site';
            case self::INSTALL_SINGLE_SITE_ON_SUBDOMAIN:
                return 'single site on subdomain multisite';
            case self::INSTALL_SINGLE_SITE_ON_SUBFOLDER:
                return 'single site on subfolder multisite';
            case self::INSTALL_RBACKUP_SINGLE_SITE:
                return 'restore single site';
            case self::INSTALL_RBACKUP_MULTISITE_SUBDOMAIN:
                return 'restore subdomain multisite';
            case self::INSTALL_RBACKUP_MULTISITE_SUBFOLDER:
                return 'restore subfolder multisite';
            case self::INSTALL_RECOVERY_SINGLE_SITE:
                return 'recovery single site';
            case self::INSTALL_RECOVERY_MULTISITE_SUBDOMAIN:
                return 'recovery subdomain multisite';
            case self::INSTALL_RECOVERY_MULTISITE_SUBFOLDER:
                return 'recovery subfolder multisite';
            case self::INSTALL_NOT_SET:
                return 'NOT SET';
            default:
                throw new Exception('Invalid installer mode');
        }
    }

    protected static function overwriteDataDefault()
    {
        return array(
            'dupVersion'       => '0',
            'wpVersion'        => '0',
            'dbhost'           => '',
            'dbname'           => '',
            'dbuser'           => '',
            'dbpass'           => '',
            'table_prefix'      => '',
            'restUrl'          => '',
            'restNonce'        => '',
            'restAuthUser'     => '',
            'restAuthPassword' => '',
            'isMultisite'      => false,
            'subdomain'        => false,
            'subsites'         => array(),
            'nextSubsiteIdAI'  => -1,
            'adminUsers'       => array(),
            'paths'            => array(),
            'urls'             => array()
        );
    }

    protected function getOverwriteDataFromParams()
    {
        $overwriteData = PrmMng::getInstance()->getValue(PrmMng::PARAM_OVERWRITE_SITE_DATA);
        if (empty($overwriteData)) {
            return false;
        }

        if (!isset($overwriteData['dbhost']) || !isset($overwriteData['dbname']) || !isset($overwriteData['dbuser']) || !isset($overwriteData['dbpass'])) {
            return false;
        }

        return array_merge(self::overwriteDataDefault(), $overwriteData);
    }

    protected function getOverwriteDataFromWpConfig()
    {
        if (($wpConfigPath = ServerConfigs::getWpConfigLocalStoredPath()) === false) {
            $wpConfigPath = DUPX_WPConfig::getWpConfigPath();
            if (!file_exists($wpConfigPath)) {
                $wpConfigPath = DUPX_WPConfig::getWpConfigDeafultPath();
            }
        }

        $overwriteData = false;

        Log::info('CHECK STATE INSTALLER WP CONFIG PATH: ' . Log::v2str($wpConfigPath), Log::LV_DETAILED);

        if (!file_exists($wpConfigPath)) {
            return $overwriteData;
        }

        $nManager = DUPX_NOTICE_MANAGER::getInstance();
        try {
            if (DUPX_WPConfig::getLocalConfigTransformer() === false) {
                throw new Exception('wp-config.php exist but isn\'t valid. continue on standard install');
            }

            $overwriteData = array_merge(
                self::overwriteDataDefault(),
                array(
                    'dbhost'       => DUPX_WPConfig::getValueFromLocalWpConfig('DB_HOST'),
                    'dbname'       => DUPX_WPConfig::getValueFromLocalWpConfig('DB_NAME'),
                    'dbuser'       => DUPX_WPConfig::getValueFromLocalWpConfig('DB_USER'),
                    'dbpass'       => DUPX_WPConfig::getValueFromLocalWpConfig('DB_PASSWORD'),
                    'table_prefix' => DUPX_WPConfig::getValueFromLocalWpConfig('table_prefix', 'variable')
                )
            );

            if (DUPX_WPConfig::getValueFromLocalWpConfig('MULTISITE', 'constant', false)) {
                $overwriteData['isMultisite'] = true;
                $overwriteData['subdomain']   = DUPX_WPConfig::getValueFromLocalWpConfig('SUBDOMAIN_INSTALL', 'constant', false);
            }
        } catch (Exception $e) {
            $overwriteData = false;
            Log::logException($e);
            $longMsg = "Exception message: " . $e->getMessage() . "\n\n";
            $nManager->addNextStepNotice(array(
                'shortMsg'    => 'wp-config.php exists but isn\'t valid. Continue on standard install.',
                'level'       => DUPX_NOTICE_ITEM::SOFT_WARNING,
                'longMsg'     => $longMsg,
                'longMsgMode' => DUPX_NOTICE_ITEM::MSG_MODE_PRE
            ));
            $nManager->saveNotices();
        } catch (Error $e) {
            $overwriteData = false;
            Log::logException($e);
            $longMsg = "Exception message: " . $e->getMessage() . "\n\n";
            $nManager->addNextStepNotice(array(
                'shortMsg'    => 'wp-config.php exists but isn\'t valid. Continue on standard install.',
                'level'       => DUPX_NOTICE_ITEM::SOFT_WARNING,
                'longMsg'     => $longMsg,
                'longMsgMode' => DUPX_NOTICE_ITEM::MSG_MODE_PRE
            ));
            $nManager->saveNotices();
        }

        return $overwriteData;
    }

    /**
     * Check if is bridge install
     *
     * @return bool
     */
    public static function isBridgeInstall()
    {
        return defined('DUPLICATOR_MU_PLUGIN_VERSION');
    }

    /**
     *
     * @return bool
     */
    public static function isRecoveryMode($type = null)
    {
        return self::isInstType(
            array(
                self::INSTALL_RECOVERY_SINGLE_SITE,
                self::INSTALL_RECOVERY_MULTISITE_SUBDOMAIN,
                self::INSTALL_RECOVERY_MULTISITE_SUBFOLDER
            ),
            $type
        );
    }

    /**
     *
     * @return bool
     */
    public static function isRestoreBackup($type = null)
    {
        return self::isInstType(
            array(
                self::INSTALL_RBACKUP_SINGLE_SITE,
                self::INSTALL_RBACKUP_MULTISITE_SUBDOMAIN,
                self::INSTALL_RBACKUP_MULTISITE_SUBFOLDER,
                self::INSTALL_RECOVERY_SINGLE_SITE,
                self::INSTALL_RECOVERY_MULTISITE_SUBDOMAIN,
                self::INSTALL_RECOVERY_MULTISITE_SUBFOLDER
            ),
            $type
        );
    }

    /**
     *
     * @return bool
     */
    public static function isImportFromBackendMode()
    {
        $template = PrmMng::getInstance()->getValue(PrmMng::PARAM_TEMPLATE);
        return ($template === DUPX_Template::TEMPLATE_IMPORT_BASE ||
            $template === DUPX_Template::TEMPLATE_IMPORT_ADVANCED);
    }

    /**
     *
     * @return bool
     */
    public static function isClassicInstall()
    {
        return (!self::isImportFromBackendMode() && !self::isRecoveryMode());
    }


    /**
     * Return true if new target site is multisite
     *
     * @return bool
     */
    public static function isNewSiteIsMultisite()
    {
        return self::isInstType(
            array(
                    DUPX_InstallerState::INSTALL_MULTISITE_SUBDOMAIN,
                    DUPX_InstallerState::INSTALL_MULTISITE_SUBFOLDER,
                    DUPX_InstallerState::INSTALL_RBACKUP_MULTISITE_SUBDOMAIN,
                    DUPX_InstallerState::INSTALL_RBACKUP_MULTISITE_SUBFOLDER,
                    DUPX_InstallerState::INSTALL_RECOVERY_MULTISITE_SUBDOMAIN,
                    DUPX_InstallerState::INSTALL_RECOVERY_MULTISITE_SUBFOLDER
                )
        );
    }

    /**
     *
     * @return bool
     */
    public static function isAddSiteOnMultisite($type = null)
    {
        return self::isInstType(
            array(
                self::INSTALL_SINGLE_SITE_ON_SUBDOMAIN,
                self::INSTALL_SINGLE_SITE_ON_SUBFOLDER,
                self::INSTALL_SUBSITE_ON_SUBDOMAIN,
                self::INSTALL_SUBSITE_ON_SUBFOLDER
            ),
            $type
        );
    }

    /**
     *
     * @return bool
     */
    public static function isMultisiteInstall($type = null)
    {
        return self::isInstType(
            array(
                self::INSTALL_MULTISITE_SUBDOMAIN,
                self::INSTALL_MULTISITE_SUBFOLDER
            ),
            $type
        );
    }

    /**
     *
     * @param int|array $type
     *
     * @return bool
     */
    public static function instTypeAvaiable($type)
    {
        $acceptList      = ParamDescConfigs::getInstallTypesAcceptValues();
        $typesToCheck    = is_array($type) ? $type : array($type);
        $typesAvaliables = array_intersect($acceptList, $typesToCheck);
        return (count($typesAvaliables) > 0);
    }

    /**
     *
     * @return bool
     */
    public static function isAddSiteOnMultisiteAvaiable()
    {
        return self::instTypeAvaiable(
            array(
                self::INSTALL_SINGLE_SITE_ON_SUBDOMAIN,
                self::INSTALL_SINGLE_SITE_ON_SUBFOLDER,
                self::INSTALL_SUBSITE_ON_SUBDOMAIN,
                self::INSTALL_SUBSITE_ON_SUBFOLDER
            )
        );
    }

    /**
     *
     * @return bool
     */
    public static function isMultisiteInstallAvaiable()
    {
        return self::instTypeAvaiable(
            array(
                self::INSTALL_MULTISITE_SUBDOMAIN,
                self::INSTALL_MULTISITE_SUBFOLDER
            )
        );
    }

    /**
     * this function in case of an error returns an empty array but never generates exceptions
     *
     * @param mixed[] $overwriteData
     *
     * @return array
     */
    protected function getAdminUsersOnOverwriteDatabase($overwriteData)
    {
        $adminUsers = [];
        $dbFuncs    = null;
        try {
            $dbFuncs = DUPX_DB_Functions::getInstance();

            if (!$dbFuncs->dbConnection($overwriteData)) {
                throw new Exception('GET USERS ON CURRENT DATABASE FAILED. Can\'t connect');
            }

            $usersTables = array(
                $dbFuncs->getUserTableName($overwriteData['table_prefix']),
                $dbFuncs->getUserMetaTableName($overwriteData['table_prefix'])
            );

            if (!$dbFuncs->tablesExist($usersTables)) {
                throw new Exception(
                    'GET USERS ON CURRENT DATABASE FAILED. Users tables doesn\'t exist, ' .
                    'continue with orverwrite installation but with option keep users disabled' . "\n"
                );
            }

            if (($adminUsers = $dbFuncs->getAdminUsers($overwriteData['table_prefix'])) === false) {
                $adminUsers = [];
                throw new Exception('GET USERS ON CURRENT DATABASE FAILED. OVERWRITE DB USERS NOT FOUND');
            }
        } catch (Exception $e) {
            Log::logException($e, Log::LV_DEFAULT, 'GET ADMIN USER EXECPTION BUT CONTINUE');
        } catch (Error $e) {
            Log::logException($e, Log::LV_DEFAULT, 'GET ADMIN USER EXECPTION BUT CONTINUE');
        } finally {
            if ($dbFuncs instanceof DUPX_DB_Functions) {
                $dbFuncs->closeDbConnection();
            }
        }

        return $adminUsers;
    }

    /**
     * Returns the WP version from the ./wp-includes/version.php file if it exists, otherwise '0'
     *
     * @return string WP version
     */
    protected function getWordPressVersionOverwrite()
    {
        $wp_version = '0';
        try {
            $versionFilePath = PrmMng::getInstance()->getValue(PrmMng::PARAM_PATH_WP_CORE_NEW) . "/wp-includes/version.php";
            if (!file_exists($versionFilePath) || !is_readable($versionFilePath)) {
                Log::info("WordPress Version file does not exist or is not readable at path: {$versionFilePath}");
                return $wp_version;
            }

            include($versionFilePath);
            return $wp_version;
        } catch (Exception $e) {
            Log::logException($e, Log::LV_DEFAULT, 'EXCEPTION GETTING WORDPRESS VERSION, BUT CONTINUE');
        } catch (Error $e) {
            Log::logException($e, Log::LV_DEFAULT, 'ERROR GETTING WORDPRESS VERSION, BUT CONTINUE');
        }

        return $wp_version;
    }

    /**
     * Returns the Duplicator Pro version if it exists, otherwise '0'
     *
     * @param $overwriteData
     *
     * @return string
     */
    protected function getDuplicatorVersionOverwrite($overwriteData)
    {
        $duplicatorProVersion = '0';
        try {
            $dbFuncs = DUPX_DB_Functions::getInstance();

            if (!$dbFuncs->dbConnection($overwriteData)) {
                Log::info('GET DUPLICATOR VERSION ON CURRENT DATABASE FAILED. Can\'t connect');
                return $duplicatorProVersion;
            }

            $optionsTable = DUPX_DB_Functions::getOptionsTableName($overwriteData['table_prefix']);

            if (!$dbFuncs->tablesExist($optionsTable)) {
                Log::info("GET DUPLICATOR VERSION ON CURRENT DATABASE FAILED. Options tables doesn't exist.\n");
                $dbFuncs->closeDbConnection();
                return $duplicatorProVersion;
            }

            if (($duplicatorProVersion = $dbFuncs->getDuplicatorVersion($overwriteData['table_prefix'])) === false) {
                Log::info('GET DUPLICATOR VERSION ON CURRENT DATABASE FAILED. OVERWRITE VERSION NOT FOUND');
                $dbFuncs->closeDbConnection();
                return '0';
            }

            $dbFuncs->closeDbConnection();
        } catch (Exception $e) {
            Log::logException($e, Log::LV_DEFAULT, 'GET DUPLICATOR VERSION EXECPTION BUT CONTINUE');
        } catch (Error $e) {
            Log::logException($e, Log::LV_DEFAULT, 'GET DUPLICATOR VERSION ERROR BUT CONTINUE');
        }

        return $duplicatorProVersion;
    }


    /**
     * getHtmlModeHeader
     *
     * @return string
     */
    public function getHtmlModeHeader()
    {
        $additional_info  = '<span class="requires-no-db"> - No database actions';
        $additional_info .= DUPX_ArchiveConfig::getInstance()->isDBExcluded() ? ' (Database Excluded)' : '';
        $additional_info .= '</span>';

        $additional_info .= (DUPX_ArchiveConfig::getInstance()->isDBOnly()) ? ' - Database Only' : '';
        $additional_info .= ($GLOBALS['DUPX_ENFORCE_PHP_INI']) ? '<i style="color:red"><br/>*PHP ini enforced*</i>' : '';

        switch ($this->getMode()) {
            case self::MODE_OVR_INSTALL:
                $label = 'Overwrite Install';
                $class = 'dupx-overwrite mode_overwrite';
                break;
            case self::MODE_STD_INSTALL:
                $label = 'Standard Install';
                $class = 'dupx-overwrite mode_standard';
                break;
            case self::MODE_UNKNOWN:
            default:
                $label = 'Custom Install';
                $class = 'mode_unknown';
                break;
        }

        if (strlen($additional_info)) {
            return '<span class="' . $class . '">' . $label . ' ' . $additional_info . '</span>';
        } else {
            return "<span class=\"{$class}\">{$label}</span>";
        }
    }

    /**
     * reset current mode
     *
     * @param boolean $saveParams
     *
     * @return boolean
     */
    public function resetState($saveParams = true)
    {
        $paramsManager = PrmMng::getInstance();
        $paramsManager->setValue(PrmMng::PARAM_INSTALLER_MODE, self::MODE_UNKNOWN);
        if ($saveParams) {
            return $this->save();
        } else {
            return true;
        }
    }

    /**
     * Save current installer state
     *
     * @return bool
     */
    public function save()
    {
        return PrmMng::getInstance()->save();
    }

    /**
     * Return stru if is overwrite install
     *
     * @return boolean
     */
    public static function isOverwrite()
    {
        return (PrmMng::getInstance()->getValue(PrmMng::PARAM_INSTALLER_MODE) === self::MODE_OVR_INSTALL);
    }

    /**
     * Returns true if the DB action is set to do nothing
     *
     * @return bool
     */
    public static function dbDoNothing()
    {
        return PrmMng::getInstance()->getValue(PrmMng::PARAM_DB_ACTION) === DUPX_DBInstall::DBACTION_DO_NOTHING;
    }

    /**
     * this function returns true if both the URL and path old and new path are identical
     *
     * @return bool
     */
    public static function isInstallerCreatedInThisLocation()
    {
        $paramsManager = PrmMng::getInstance();

        $urlNew  = null;
        $pathNew = null;

        if (DUPX_InstallerState::isImportFromBackendMode()) {
            $overwriteData = $paramsManager->getValue(PrmMng::PARAM_OVERWRITE_SITE_DATA);
            if (isset($overwriteData['urls']['home']) && isset($overwriteData['paths']['home'])) {
                $urlNew  = $overwriteData['urls']['home'];
                $pathNew = $overwriteData['paths']['home'];
            }
        }

        if (is_null($urlNew) || is_null($pathNew)) {
            $pathNew = $paramsManager->getValue(PrmMng::PARAM_PATH_NEW);
            $urlNew  = $paramsManager->getValue(PrmMng::PARAM_URL_NEW);
        }

        return self::urlAndPathAreSameOfArchive($urlNew, $pathNew);
    }

    /**
     * isSameLocationOfArtiche
     *
     * @param string $urlNew
     * @param string $pathNew
     *
     * @return bool
     */
    public static function urlAndPathAreSameOfArchive($urlNew, $pathNew)
    {
        $archiveConfig = \DUPX_ArchiveConfig::getInstance();
        $urlOld        = rtrim($archiveConfig->getRealValue('homeUrl'), '/');
        $paths         = $archiveConfig->getRealValue('archivePaths');
        $pathOld       = $paths->home;
        $paths         = $archiveConfig->getRealValue('originalPaths');
        $pathOldOrig   = $paths->home;

        $urlNew      = SnapIO::untrailingslashit($urlNew);
        $urlOld      = SnapIO::untrailingslashit($urlOld);
        $pathNew     = SnapIO::untrailingslashit($pathNew);
        $pathOld     = SnapIO::untrailingslashit($pathOld);
        $pathOldOrig = SnapIO::untrailingslashit($pathOldOrig);

        return (($pathNew === $pathOld || $pathNew === $pathOldOrig) && $urlNew === $urlOld);
    }

    /**
     * get migration data to store in wp-options
     *
     * @return array
     */
    public static function getMigrationData()
    {
        $sec           = Security::getInstance();
        $paramsManager = PrmMng::getInstance();

        return array(
            'installType'         => $paramsManager->getValue(PrmMng::PARAM_INST_TYPE),
            'restoreBackupMode'   => self::isRestoreBackup(),
            'recoveryMode'        => self::isRecoveryMode(),
            'archivePath'         => $sec->getArchivePath(),
            'packageHash'         => DUPX_Package::getPackageHash(),
            'installerPath'       => $sec->getBootFilePath(),
            'installerBootLog'    => $sec->getBootLogFile(),
            'installerLog'        => Log::getLogFilePath(),
            'dupInstallerPath'    => DUPX_INIT,
            'origFileFolderPath'  => InstallerOrigFileMng::getInstance()->getMainFolder(),
            'safeMode'            => $paramsManager->getValue(PrmMng::PARAM_SAFE_MODE),
            'cleanInstallerFiles' => $paramsManager->getValue(PrmMng::PARAM_AUTO_CLEAN_INSTALLER_FILES)
        );
    }

    /**
     *
     * @return string
     */
    public static function getAdminLogin()
    {
        $paramsManager = PrmMng::getInstance();
        if (self::isAddSiteOnMultisite()) {
            $overwriteData = $paramsManager->getValue(PrmMng::PARAM_OVERWRITE_SITE_DATA);
            $loginUrl      = $overwriteData['urls']['login'];
        } else {
            $oldUrl        = $paramsManager->getValue(PrmMng::PARAM_SITE_URL_OLD);
            $newUrl        = $paramsManager->getValue(PrmMng::PARAM_SITE_URL);
            $archiveConfig = DUPX_ArchiveConfig::getInstance();
            $loginUrl      = DUPX_ArchiveConfig::getNewSubUrl($oldUrl, $newUrl, $archiveConfig->getRealValue("loginUrl"));
        }
        return $loginUrl;
    }

    /**
     *
     * @return int
     */
    public static function getInstType()
    {
        return PrmMng::getInstance()->getValue(PrmMng::PARAM_INST_TYPE);
    }

    /**
     * @param int|array $type        list of types to check
     * @param int       $typeToCheck if is null get param install time or check this
     *
     * @return bool
     */
    public static function isInstType($type, $typeToCheck = null)
    {
        $currentType = is_null($typeToCheck) ? self::getInstType() : $typeToCheck;
        if (is_array($type)) {
            return in_array($currentType, $type);
        } else {
            return $currentType === $type;
        }
    }
}
