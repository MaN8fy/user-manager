<?php

namespace App\PublicModule\Presenters;

use App\Components\Factories\CustomForm;
use Nette\Application\UI\Form;
use Tracy\Debugger;

/**
 * Sign presenter.
 */
class SignPresenter extends BasePresenter
{
    /**
     * startup
     *
     * @return void
     */
    public function startup(): void
    {
        parent::startup();
    }

    /**
     * beforeRender
     *
     * @return void
     */
    public function beforeRender(): void
    {
        parent::beforeRender();
    }

    /**
     * render login
     *
     * @return void
     */
    public function renderIn(): void
    {
        if ($this->user->isLoggedIn()) {
            $this->redirect(":Sys:Homepage:default");
        }
    }

    /**
     * render registration
     *
     * @return void
     */
    public function renderUp(): void
    {
        if ($this->user->isLoggedIn()) {
            $this->redirect(":Sys:Homepage:default");
        }
    }

    /**
     * logout user
     *
     * @return void
     */
    public function actionOut(): void
    {
        $this->user->logout();
        $this->redirect(":Public:Sign:in");
    }

    /**
     * registration form
     *
     * @return Form
     */
    protected function createComponentRegistrationForm(): Form
    {
        $form = new CustomForm();
        $form->addText('firstname', 'First name:')
            ->setRequired('Please enter your firstname.');

        $form->addText('lastname', 'Last name:')
            ->setRequired('Please enter your lastname.');

        $form->addText('email', 'Email:')
            ->setRequired('Please enter your email.')
            ->addRule(Form::EMAIL, 'Please enter a valid email address.');

        $form->addText('username', 'Username:')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password:')
            ->setRequired('Please enter your password.');

        $form->addPassword('password2', 'Password again:')
            ->setRequired('Please enter your password again.')
            ->addRule(Form::EQUAL, 'Passwords do not match.', $form['password']);

        $form->addSubmit('send', 'Register');

        $form->onSuccess[] = [$this, 'registrationFormSucceeded'];
        return $form;
    }

    /**
     * registrationFormSucceeded
     *
     * @param  Form  $form
     * @param  array $values
     * @return void
     */
    public function registrationFormSucceeded(Form $form, array $values): void
    {
        try {
            $this->userModel->registerUser($values);

            $this->flashMessage('Registration successful.', 'success');
        } catch (\Nette\Database\UniqueConstraintViolationException $e) {
            $this->flashMessage('Username or email is already taken.', 'danger');
            $this->redirect('this');
        } catch (\Exception $e) {
            Debugger::log($e, \Tracy\ILogger::ERROR);

            $this->flashMessage('Something went wrong while saving. Try again later.', 'danger');
            $this->redirect('this');
        }
        $this->redirect(':Public:Sign:in');
    }

    /**
     * login form
     *
     * @return Form
     */
    protected function createComponentLoginForm(): Form
    {
        $form = new CustomForm();
        $form->addText('username', 'Username:')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password:')
            ->setRequired('Please enter your password.');

        $form->addCheckbox('remember', 'Remember me');

        $form->addSubmit('submit', 'Login');

        $form->onSuccess[] = [$this, 'loginFormSucceeded'];
        return $form;
    }

    /**
     * loginFormSucceeded
     *
     * @param  Form  $form
     * @param  array $values
     * @return void
     */
    public function loginFormSucceeded(Form $form, array $values): void
    {
        try {
            $this->user->login($values['username'], $values['password']);
            if ($values['remember']) {
                $loginExpiration = $this->container->getParameters()['login_expiration'];
                $this->user->setExpiration($loginExpiration);
            }
        } catch (\Nette\Security\AuthenticationException $e) {
            $this->flashMessage($e->getMessage(), 'danger');
            $this->redirect('this');
        } catch (\Exception $e) {
            Debugger::log($e, \Tracy\ILogger::ERROR);

            $this->flashMessage('Something went wrong. Try again later.', 'danger');
            $this->redirect('this');
        }
        $this->redirect(':Sys:Homepage:default');
    }
}
