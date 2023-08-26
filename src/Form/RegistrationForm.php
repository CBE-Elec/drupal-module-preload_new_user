<?php
/**
 * @file
 * Contains \Drupal\student_registration\Form\RegistrationForm.
 */
namespace Drupal\preload_new_user\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityFormBuilder;
use Drupal\user\RegisterForm;

class RegistrationForm extends RegisterForm {
  /**
   * {@inheritdoc}
   */
  // public function getFormId() {
  //   return 'preload_new_user_form';
  // }
  

  public function buildForm(array $form, FormStateInterface $form_state) {

$entity = \Drupal::entityTypeManager()->getStorage('user')->create(array());
//$formObject = \Drupal::entityTypeManager()->getFormObject('user', 'register')->setEntity($entity);
$form =$this->getForm($entity, 'register');
//$form = \Drupal::service('entity.form_builder')->getForm($entity, 'register');
exit();
//$form_builder = EntityFormBuilder::getForm($entity, 'register');
//echo('form = '); var_dump($form); echo("<br>");

   $form['student_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Name:'),
      '#required' => TRUE,
    );
    $form['student_rollno'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Enrollment Number:'),
      '#required' => TRUE,
    );
    $form['student_mail'] = array(
      '#type' => 'email',
      '#title' => t('Enter Email ID:'),
      '#required' => TRUE,
    );
    $form['student_phone'] = array (
      '#type' => 'tel',
      '#title' => t('Enter Contact Number'),
    );
    $form['student_dob'] = array (
      '#type' => 'date',
      '#title' => t('Enter DOB:'),
      '#required' => TRUE,
    );
    $form['student_gender'] = array (
      '#type' => 'select',
      '#title' => ('Select Gender:'),
      '#options' => array(
        'Male' => t('Male'),
    'Female' => t('Female'),
        'Other' => t('Other'),
      ),
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Register'),
      '#button_type' => 'primary',
    );
    return $form;
  }
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if(strlen($form_state->getValue('student_rollno')) < 8) {
      $form_state->setErrorByName('student_rollno', $this->t('Please enter a valid Enrollment Number'));
    }
    if(strlen($form_state->getValue('student_phone')) < 10) {
      $form_state->setErrorByName('student_phone', $this->t('Please enter a valid Contact Number'));
    }
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addMessage(t("Student Registration Done!! Registered Values are:"));
  foreach ($form_state->getValues() as $key => $value) {
    \Drupal::messenger()->addMessage($key . ': ' . $value);
    }
  }

  //  public function processForm($form_id, FormStateInterface &$form_state, &$form) {
  //   $form_state->setValues([]);

  //   // With GET, these forms are always submitted if requested.
  //   if ($form_state->isMethodType('get') && $form_state->getAlwaysProcess()) {
  //     $input = $form_state->getUserInput();
  //     if (!isset($input['form_build_id'])) {
  //       $input['form_build_id'] = $form['#build_id'];
  //     }
  //     if (!isset($input['form_id'])) {
  //       $input['form_id'] = $form_id;
  //     }
  //     if (!isset($input['form_token']) && isset($form['#token'])) {
  //       $input['form_token'] = $this->csrfToken->get($form['#token']);
  //     }
  //     $form_state->setUserInput($input);
  //   }

  //   // self::doBuildForm() finishes building the form by calling element
  //   // #process functions and mapping user input, if any, to #value properties,
  //   // and also storing the values in $form_state->getValues(). We need to
  //   // retain the unprocessed $form in case it needs to be cached.
  //   $unprocessed_form = $form;
  //   $form = $this->doBuildForm($form_id, $form, $form_state);

  //   // Only process the input if we have a correct form submission.
  //   if ($form_state->isProcessingInput()) {
  //     // Form values for programmed form submissions typically do not include a
  //     // value for the submit button. But without a triggering element, a
  //     // potentially existing #limit_validation_errors property on the primary
  //     // submit button is not taken account. Therefore, check whether there is
  //     // exactly one submit button in the form, and if so, automatically use it
  //     // as triggering_element.
  //     $buttons = $form_state->getButtons();
  //     if ($form_state->isProgrammed() && !$form_state->getTriggeringElement() && count($buttons) == 1) {
  //       $form_state->setTriggeringElement(reset($buttons));
  //     }
  //     $this->formValidator->validateForm($form_id, $form, $form_state);

  //     // If there are no errors and the form is not rebuilding, submit the form.
  //     if (!$form_state->isRebuilding() && !FormState::hasAnyErrors()) {
  //       $submit_response = $this->formSubmitter->doSubmitForm($form, $form_state);
  //       // If this form was cached, delete it from the cache after submission.
  //       if ($form_state->isCached()) {
  //         $this->deleteCache($form['#build_id']);
  //       }
  //       // If the form submission directly returned a response, return it now.
  //       if ($submit_response) {
  //         return $submit_response;
  //       }
  //     }

  //     // Don't rebuild or cache form submissions invoked via self::submitForm().
  //     if ($form_state->isProgrammed()) {
  //       return;
  //     }

  //     // If $form_state->isRebuilding() has been set and input has been
  //     // processed without validation errors, we are in a multi-step workflow
  //     // that is not yet complete. A new $form needs to be constructed based on
  //     // the changes made to $form_state during this request. Normally, a submit
  //     // handler sets $form_state->isRebuilding() if a fully executed form
  //     // requires another step. However, for forms that have not been fully
  //     // executed (e.g., Ajax submissions triggered by non-buttons), there is no
  //     // submit handler to set $form_state->isRebuilding(). It would not make
  //     // sense to redisplay the identical form without an error for the user to
  //     // correct, so we also rebuild error-free non-executed forms, regardless
  //     // of $form_state->isRebuilding().
  //     // @todo Simplify this logic; considering Ajax and non-HTML front-ends,
  //     //   along with element-level #submit properties, it makes no sense to
  //     //   have divergent form execution based on whether the triggering element
  //     //   has #executes_submit_callback set to TRUE.
  //     if (($form_state->isRebuilding() || !$form_state->isExecuted()) && !FormState::hasAnyErrors()) {
  //       // Form building functions (e.g., self::handleInputElement()) may use
  //       // $form_state->isRebuilding() to determine if they are running in the
  //       // context of a rebuild, so ensure it is set.
  //       $form_state->setRebuild();
  //       $form = $this->rebuildForm($form_id, $form_state, $form);
  //     }
  //   }

  //   // After processing the form, the form builder or a #process callback may
  //   // have called $form_state->setCached() to indicate that the form and form
  //   // state shall be cached. But the form may only be cached if
  //   // $form_state->disableCache() is not called. Only cache $form as it was
  //   // prior to self::doBuildForm(), because self::doBuildForm() must run for
  //   // each request to accommodate new user input. Rebuilt forms are not cached
  //   // here, because self::rebuildForm() already takes care of that.
  //   if (!$form_state->isRebuilding() && $form_state->isCached()) {
  //     $this->setCache($form['#build_id'], $unprocessed_form, $form_state);
  //   }
  // }


}



  /**
   * {@inheritdoc}
   */
  // public function buildForm(array $form, FormStateInterface $form_state) {
  // // Retrieve the default user registration form of Drupal for a new user.
  // //$user_register_form = \Drupal::formBuilder()->getForm('Drupal\user\RegisterForm');

  //   // Copy the elements from the default user registration form into the custom form.
  //   //$form += $user_register_form;

  //   // Add additional custom fields to the form.
  //   $form['name'] = [
  //     '#type' => 'textfield',
  //     '#title' => $this->t('Custom Username'),
  //     '#required' => TRUE,
  //   ];
  //   // ... Add other custom fields here.

  //   $form['actions']['submit']['#value'] = $this->t('Create User');

  //   return $form;
  // }



  // /**
  //  * {@inheritdoc}
  //  */
  // public function validateForm(array &$form, FormStateInterface $form_state) {
  //   // Add custom validation logic if needed.
  // }

  // /**
  //  * {@inheritdoc}
  //  */
  // public function submitForm(array &$form, FormStateInterface $form_state) {
  //   // Retrieve the values from the form.
  //   // $values = $form_state->getValues();

    // // Create a new user.
    // $user = User::create();
    // $user->setPassword($values['pass']);
    // $user->enforceIsNew();
    // $user->setEmail($values['mail']);
    // $user->setUsername($values['name']);
    // $user->set('init', $values['mail']);
    // $user->set('status', 1);

    // // Optionally: Assign a role to the user.
    // $user->addRole('custom_role');

    // // Save the user.
    // $user->save();

    // // Optionally: Redirect the user to another page after form submission.
    // $form_state->setRedirect('<front>');
