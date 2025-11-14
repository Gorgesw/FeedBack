<?php
namespace Src\Controllers;

use Src\Core\Controller;

class controllerAgradecimento extends Controller
{
  public function index(): void
  {
    $this->view('agradecimento');
  }
}