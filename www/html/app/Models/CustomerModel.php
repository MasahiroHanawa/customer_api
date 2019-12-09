<?php
namespace App\Models;

use App\Models\CustomerModelInterface;

class CustomerModel extends MainModel implements CustomerModelInterface
{
  public function __construct($options = [])
  {
    $options['table'] = 'customers';
    parent::__construct($options);
  }

  public function validate($params)
  {
    $errors = [];
    $emptyEmail = $this->isEmpty(['email' => $params['email']]);
    $isEmail = $this->isEmail($params['email']);
    $id = empty($params['id']) ? null : ['id' => $params['id']];
    $hasEmail = $this->hasEmail(
      ['email' => $params['email']],
      $id
    );
    if (!empty($emptyEmail))
    {
      $errors['email'] = $emptyEmail;
    } elseif (!empty($isEmail))
    {
      $errors['email'] = $isEmail;
    } elseif (!empty($hasEmail))
    {
      $errors['email'] = $hasEmail;
    }
    $emptyPassword = $this->isEmpty(['password' => $params['password']]);
    $emptyFirstName = $this->isEmpty(['first_name' => $params['first_name']]);
    $emptyLastName = $this->isEmpty(['last_name' => $params['last_name']]);
    if (!empty($emptyPassword)) {
      $errors['password'] = $emptyPassword;
    }
    if (!empty($emptyFirstName)) {
      $errors['first_name'] = $emptyFirstName;
    }
    if (!empty($emptyLastName)) {
      $errors['last_name'] = $emptyLastName;
    }
    return $errors;
  }

  public function getCustomerList()
  {
    $list = $this->select();
    return $list;
  }

  public function createCustomer($params)
  {
    $list = $this->create(
      [
        'email' => $params['email'],
        'password' => $params['password'],
        'first_name' => $params['first_name'],
        'last_name' => $params['last_name'],
      ]
    );
    return $list;
  }

  public function updateCustomer($params)
  {
    $result = $this->update(
      [
        'email' => $params['email'],
        'password' => $params['password'],
        'first_name' => $params['first_name'],
        'last_name' => $params['last_name'],
      ],
      $params['id']
    );
    return $result;
  }

  public function deleteCustomer($params)
  {
    $result = $this->delete(
      $params['id']
    );
    return $result;
  }

  public function deleteAllCustomer()
  {
    $result = $this->deleteAll(
    );
    return $result;
  }
}