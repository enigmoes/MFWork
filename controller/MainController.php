<?php

class MainController extends Controller
{

   public function index()
   {
      $this->view('index', [
         'var' => 'Ejemplo de paso de variable',
      ]);
      //$this->redirect(Router::url([
      //   'controller' => 'main',
      //   'action' => 'test',
      //   '?' => [
      //      'usuario' => 'pepe',
      //      'grupo' => '5'
      //   ]
      //]));
   }

   public function test()
   {
      $this->view('test');
   }

}