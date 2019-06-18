<?php

require_once 'eventregistrationcontactsearch.civix.php';
use CRM_Eventregistrationcontactsearch_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function eventregistrationcontactsearch_civicrm_config(&$config) {
  _eventregistrationcontactsearch_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function eventregistrationcontactsearch_civicrm_xmlMenu(&$files) {
  _eventregistrationcontactsearch_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function eventregistrationcontactsearch_civicrm_install() {
  _eventregistrationcontactsearch_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function eventregistrationcontactsearch_civicrm_postInstall() {
  _eventregistrationcontactsearch_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function eventregistrationcontactsearch_civicrm_uninstall() {
  _eventregistrationcontactsearch_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function eventregistrationcontactsearch_civicrm_enable() {
  _eventregistrationcontactsearch_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function eventregistrationcontactsearch_civicrm_disable() {
  _eventregistrationcontactsearch_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function eventregistrationcontactsearch_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _eventregistrationcontactsearch_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function eventregistrationcontactsearch_civicrm_managed(&$entities) {
  _eventregistrationcontactsearch_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function eventregistrationcontactsearch_civicrm_caseTypes(&$caseTypes) {
  _eventregistrationcontactsearch_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function eventregistrationcontactsearch_civicrm_angularModules(&$angularModules) {
  _eventregistrationcontactsearch_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function eventregistrationcontactsearch_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _eventregistrationcontactsearch_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function eventregistrationcontactsearch_civicrm_entityTypes(&$entityTypes) {
  _eventregistrationcontactsearch_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function eventregistrationcontactsearch_civicrm_buildForm($formName, &$form) {
  if (in_array($formName, [
      'CRM_Event_Form_Registration_AdditionalParticipant',
      'CRM_Event_Form_Registration_Register'
    ]) && $form->_values['event']['is_multiple_registrations']
  ) {
    if ($formName == 'CRM_Event_Form_Registration_Register'
      && $form->getContactID() !== 0
    ) {
      return;
    }
    $onlinePaymentProcessorEnabled = FALSE;
    if (!empty($form->getVar('_paymentProcessors'))) {
      foreach ($form->getVar('_paymentProcessors') as $key => $name) {
        if ($name['billing_mode'] == 1) {
          $onlinePaymentProcessorEnabled = TRUE;
        }
      }
    }
    if ($formName == 'CRM_Event_Form_Registration_AdditionalParticipant') {
      $customPre = $form->_values['custom_pre_id'];
      $customPost = $form->_values['custom_post_id'];
      $form->_values['custom_pre_id'] = $form->_values['additional_custom_pre_id'];
      $form->_values['custom_post_id'] = $form->_values['additional_custom_post_id'];
    }
    $form->addCIDZeroOptions($onlinePaymentProcessorEnabled);
    $form->assign('nocid', TRUE);
    if ($formName == 'CRM_Event_Form_Registration_AdditionalParticipant') {
      $form->_values['custom_pre_id'] = $customPre;
      $form->_values['custom_post_id'] = $customPost;
      CRM_Core_Region::instance('page-body')->add([
        'template' => 'CRM/EventRegistrationContactSearch/CidZero.tpl',
      ]);
    }
  }
}
