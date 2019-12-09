<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Models\CustomerModel;

final class CustomerModelTest extends TestCase
{

  public function testCreateCustomerEmailInvalid()
  {
    $customerModel = new CustomerModel(['env' => 'test']);

    $wrongEmail = $customerModel->validate([
      'email' => 'test',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
    ]);

    $emptyEmail = $customerModel->validate([
      'email' => '',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
    ]);

    $customerModel->createCustomer([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
    ]);

    $registeredEmail = $customerModel->validate([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
    ]);

    $this->assertEquals("Input correctly email", $wrongEmail['email']);
    $this->assertEquals("Input email", $emptyEmail['email']);
    $this->assertEquals("This email already registered", $registeredEmail['email']);
  }

  public function testCreateCustomerPasswordInvalid()
  {
    $customerModel = new CustomerModel(['env' => 'test']);

    $emptyPassword = $customerModel->validate([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => '',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
    ]);

    $this->assertEquals("Input password", $emptyPassword['password']);
  }

  public function testCreateCustomerFirstNameInvalid()
  {
    $customerModel = new CustomerModel(['env' => 'test']);

    $emptyFirstName = $customerModel->validate([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => 'secret',
      'first_name' => '',
      'last_name' => 'Hanawa',
    ]);

    $this->assertEquals("Input first_name", $emptyFirstName['first_name']);
  }

  public function testCreateCustomerLastNameInvalid()
  {
    $customerModel = new CustomerModel(['env' => 'test']);

    $emptyLastName = $customerModel->validate([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => '',
    ]);

    $this->assertEquals("Input last_name", $emptyLastName['last_name']);
  }

  public function testCreateAndReadCustomer()
  {

    $customerModel = new CustomerModel(['env' => 'test']);

    $customerModel->deleteAllCustomer();

    $customerModel->createCustomer([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
    ]);

    $list = $customerModel->getCustomerList();

    $this->assertEquals("cosmic.wonder.jeans@gmail.com", $list[0]['email']);
    $this->assertEquals("secret", $list[0]['password']);
    $this->assertEquals("Masahiro", $list[0]['first_name']);
    $this->assertEquals("Hanawa", $list[0]['last_name']);
    $this->assertCount(1,$list);
  }


  public function testUpdateCustomerEmailInvalid()
  {
    $customerModel = new CustomerModel(['env' => 'test']);

    $list = $customerModel->getCustomerList();

    $wrongEmail = $customerModel->validate([
      'email' => 'test',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
      'id' => $list[0]['id'],
    ]);

    $emptyEmail = $customerModel->validate([
      'email' => '',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
      'id' => $list[0]['id'],
    ]);

    $passedEmail = $customerModel->validate([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
      'id' => $list[0]['id'],
    ]);

    $customerModel->createCustomer([
      'email' => 'masahirohanawa@gmail.com',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
    ]);

    $registeredEmail = $customerModel->validate([
      'email' => 'masahirohanawa@gmail.com',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
      'id' => $list[0]['id'],
    ]);

    $this->assertEquals("Input correctly email", $wrongEmail['email']);
    $this->assertEquals("Input email", $emptyEmail['email']);
    $this->assertEquals(null, $passedEmail['email']);
    $this->assertEquals("This email already registered", $registeredEmail['email']);
  }

  public function testUpdateCustomerPasswordInvalid()
  {
    $customerModel = new CustomerModel(['env' => 'test']);

    $emptyPassword = $customerModel->validate([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => '',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
    ]);

    $this->assertEquals("Input password", $emptyPassword['password']);
  }

  public function testUpdateCustomerFirstNameInvalid()
  {
    $customerModel = new CustomerModel(['env' => 'test']);

    $emptyFirstName = $customerModel->validate([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => 'secret',
      'first_name' => '',
      'last_name' => 'Hanawa',
    ]);

    $this->assertEquals("Input first_name", $emptyFirstName['first_name']);
  }

  public function testUpdateCustomerLastNameInvalid()
  {
    $customerModel = new CustomerModel(['env' => 'test']);

    $emptyLastName = $customerModel->validate([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => '',
    ]);

    $this->assertEquals("Input last_name", $emptyLastName['last_name']);
  }

  public function testUpdateCustomer()
  {
    $customerModel = new CustomerModel(['env' => 'test']);
    $list = $customerModel->getCustomerList();

    $customerModel->updateCustomer([
      'id' => $list[0]['id'],
      'email' => 'masahirohanawa0405@gmail.com',
      'password' => 'test_edit',
      'first_name' => 'Johnson',
      'last_name' => 'Statham',
    ]);

    $list = $customerModel->getCustomerList();

    $this->assertEquals("masahirohanawa0405@gmail.com", $list[0]['email']);
    $this->assertEquals("test_edit", $list[0]['password']);
    $this->assertEquals("Johnson", $list[0]['first_name']);
    $this->assertEquals("Statham", $list[0]['last_name']);
  }

  public function testDeleteCustomer()
  {
    $customerModel = new CustomerModel(['env' => 'test']);

    $customerModel->deleteAllCustomer();

    $customerModel->createCustomer([
      'email' => 'cosmic.wonder.jeans@gmail.com',
      'password' => 'secret',
      'first_name' => 'Masahiro',
      'last_name' => 'Hanawa',
    ]);

    $list = $customerModel->getCustomerList();

    $customerModel->deleteCustomer([
      'id' => $list[0]['id']
    ]);

    $list = $customerModel->getCustomerList();

    $this->assertCount(0,$list);
  }
}