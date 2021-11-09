<?php

namespace Piwik\Plugins\TrackingCodeCustomizer;

use Piwik\Piwik;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;

/**
 * Defines Settings for TrackingCodeCustomizer.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->metric->getValue();
 * $settings->description->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
   
    public $idSite;
    public $protocol;
    public $piwikUrl;
    public $httpsPiwikUrl;
    public $options;
    public $optionsBeforeTrackerUrl;
    public $piwikJs;
    public $piwikPhp;
    public $paqVariable;
    public $removePiwikBranding;
    
    const TEXTBOX_SETTINGS = array("size"=> 65);

    protected function init()
    {

        
        $this->idSite = $this->createIdSiteSetting();
        $this->protocol = $this->createProtocolSetting();
        $this->piwikUrl = $this->createInstallUrlSetting();
        $this->httpsPiwikUrl = $this->createSecureInstallUrlSetting();
        $this->options = $this->createOptionsSetting();
        $this->optionsBeforeTrackerUrl = $this->createOptionsBeforeTrackerUrlSetting();
        $this->piwikJs = $this->createPiwikJsSetting();
        $this->piwikPhp = $this->createPiwikPhpSetting();
        $this->paqVariable = $this->createPaqVariableSetting();
        $this->removePiwikBranding = $this->createRemovePiwikBrandingSetting();

    }
    
    private function createIdSiteSetting(){
        return $this->makeSetting('idSite', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('idSiteSettingTitle');
            $field->introduction = $this->t('PluginDescription');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array("size" => "6", "maxlength" => "8");
            $field->description = $this->t('idSiteSettingDescription');
            $field->inlineHelp = sprintf($this->t('idSiteSettingHelp'),$this->t('idSiteSettingDefault'));
            $field->validate = function ($value, $setting) {
                if ($value != "" && preg_match("/^[0-9]+$/",$value) !== 1) {
                throw new \Exception('Value is invalid. Must be positive integer');
                }
            };
            
        });
    }
    
    private function createProtocolSetting(){
        return $this->makeSetting('protocol', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('protocolSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array("size" => "10", "maxlength" => "8");
            $field->description = $this->t('protocolSettingDescription');
            $field->inlineHelp = sprintf($this->t('protocolSettingHelp'),$this->t('protocolSettingDefault'));
            $field->validate = function ($value, $setting) {
                if ($value != "" && !($value == "http://" || $value == "https://")) {
                    throw new \Exception('Value is invalid');
                }
            };
        });
    }
    
    private function createInstallUrlSetting(){
        return $this->makeSetting('piwikUrl', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('piwikUrlSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->description = $this->t('piwikUrlSettingDescription');
            $field->inlineHelp = sprintf($this->t('piwikUrlSettingHelp'),$this->t('piwikUrlSettingDefault'));
        });
    }
    
    private function createSecureInstallUrlSetting(){
        return $this->makeSetting('httpsPiwikUrl', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('httpsPiwikUrlSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->description = $this->t('httpsPiwikUrlSettingDescription');
            $field->inlineHelp = sprintf($this->t('httpsPiwikUrlSettingHelp'),$this->t('httpsPiwikUrlSettingDefault'));            
        });
    }
    
    private function createOptionsSetting(){
        return $this->makeSetting('options', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('optionsSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXTAREA;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->description = $this->t('optionsSettingDescription');
            $field->inlineHelp = sprintf($this->t('optionsSettingHelp'),$this->t('optionsSettingDefault'));
        });
    }
    
    private function createOptionsBeforeTrackerUrlSetting(){
        return $this->makeSetting('optionsBeforeTrackerUrl', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('optionsBeforeTrackerUrlSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXTAREA;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->description = $this->t('optionsBeforeTrackerUrlSettingDescription');
            $field->inlineHelp = sprintf($this->t('optionsBeforeTrackerUrlHelp'),$this->t('optionsBeforeTrackerUrlSettingDefault'));
        });
    }

    private function createPiwikJsSetting(){
        return $this->makeSetting('piwikJs', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('piwikJsSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->inlineHelp = $this->t("piwikJsSettingHelp");
        });
    }

    private function createPiwikPhpSetting(){
        return $this->makeSetting('piwikPhp', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('piwikPhpSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->inlineHelp = $this->t("piwikPhpSettingHelp");
        });
    }

    private function createPaqVariableSetting(){
        return $this->makeSetting('paqVariable', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('paqVariableSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->inlineHelp = $this->t("paqVariableSettingHelp");
        });
    }

    private function createRemovePiwikBrandingSetting(){
        return $this->makeSetting('removePiwikBranding', $default = "", FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = $this->t('removePiwikBrandingSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
            $field->inlineHelp = $this->t("removePiwikBrandingSettingHelp");
        });
    }

    
    private function t($translate_token){
        return Piwik::translate("TrackingCodeCustomizer_".$translate_token);
    }
}
