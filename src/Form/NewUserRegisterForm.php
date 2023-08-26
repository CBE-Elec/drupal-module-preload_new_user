<?php

namespace Drupal\preload_new_user\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

//class preload_new_user extends RegisterForm {

use Drupal\user\RegisterForm;

/**
 * Provides a user login form.
 */
class NewUserRegisterForm extends RegisterForm {

 public function getEntityTypeId(): ?string {
    echo($this->entityTypeId); exit();
    return $this->entityTypeId;
    }


    /**
     * {@inheritdoc}
     */
    public function form(array $form, FormStateInterface $form_state) {

        $form = parent::form($form, $form_state);

        // Change the form here
        $form['test'] = [
          '#markup' => '<p>Test extended form</p>',
        ];
        return $form;
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


}
