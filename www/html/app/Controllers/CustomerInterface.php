<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

interface CustomerInterface
{
  public function index(Request $request);
  public function create(Request $request);
  public function update(Request $request);
  public function delete(Request $request);
}
