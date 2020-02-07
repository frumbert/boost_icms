<?php

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // Create settings page with tabs.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingboost_icms', get_string('configtitle', 'theme_boost_icms', null, true));
    $page = new admin_settingpage('theme_boost_icms_general', get_string('generalsettings', 'theme_boost_icms'));

    // Preset.
    $name = 'theme_boost_icms/preset';
    $title = get_string('preset', 'theme_boost_icms');
    $description = get_string('preset_desc', 'theme_boost_icms');
    $default = 'default.scss';

    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_boost_icms', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_boost_icms/presetfiles';
    $title = get_string('presetfiles','theme_boost_icms');
    $description = get_string('presetfiles_desc', 'theme_boost_icms');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

   // Background image setting.
    $name = 'theme_boost_icms/backgroundimage';
    $title = get_string('backgroundimage', 'theme_boost');
    $description = get_string('backgroundimage_desc', 'theme_boost_icms');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'backgroundimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $body-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_boost_icms/brandcolor';
    $title = get_string('brandcolor', 'theme_boost_icms');
    $description = get_string('brandcolor_desc', 'theme_boost_icms');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);

    // Advanced settings.
    $page = new admin_settingpage('theme_boost_icms_advanced', get_string('advancedsettings', 'theme_boost_icms'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_boost_icms/scsspre',
        get_string('rawscsspre', 'theme_boost_icms'), get_string('rawscsspre_desc', 'theme_boost_icms'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_boost_icms/scss', get_string('rawscss', 'theme_boost_icms'),
        get_string('rawscss_desc', 'theme_boost_icms'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}