<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Controllers\CustomerInterface;
use App\Models\CustomerModel;

class CustomerController implements CustomerInterface
{

  public function index(Request $request)
  {
    $customerModel = new CustomerModel;
    $list = $customerModel->getCustomerList();
    return new Response(
      json_encode(['test' => $list]),
      Response::HTTP_OK,
      ['content-type' => 'application/json']
    );
  }

  public function create(Request $request)
  {
    $customerModel = new CustomerModel;
    $validate = $customerModel->validate($request->request->all());
    if (empty($validate))
    {
      $result = $customerModel->createCustomer($request->request->all());
    } else {
      $result = ["errors" => $validate];
    }
    return new Response(
      json_encode(['result' => $result]),
      Response::HTTP_OK,
      ['content-type' => 'application/json']
    );
  }

  public function update(Request $request)
  {
    $customerModel = new CustomerModel;
    $validate = $customerModel->validate($request->request->all());
    if (empty($validate))
    {
      $result = $customerModel->updateCustomer($request->request->all());
    } else {
      $result = ["errors" => $validate];
    }
    return new Response(
      json_encode(['result' => $result]),
      Response::HTTP_OK,
      ['content-type' => 'application/json']
    );
  }

  public function delete(Request $request)
  {
    $customerModel = new CustomerModel;
    $result = $customerModel->deleteCustomer($request->request->all());
    return new Response(
      json_encode(['result' => $result]),
      Response::HTTP_OK,
      ['content-type' => 'application/json']
    );
  }

}