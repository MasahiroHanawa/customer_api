<?php
namespace App\Models;

interface CustomerModelInterface
{
  public function validate($params);
  public function getCustomerList();
  public function createCustomer($params);
  public function updateCustomer($params);
  public function deleteCustomer($params);
}
