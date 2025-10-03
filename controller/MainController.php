<?php
declare(strict_types=1);

use function Debugguer\debug;

class MainController extends Controller
{

   public function index()
   {
      $this->set([
         'var' => 'Ejemplo de paso de variable',
      ]);
   }

   public function add()
   {
      if ($this->request->is('POST')) {
         // Obtenemos datos
         $request = $this->request->getData();
         // Creamos nuevo usuario
         $newUser = $this->Users->newEmptyEntity();
         // Vinculamos datos
         $user = $this->Users->patchEntity($newUser, $request);
         // debug(get_object_vars($user));
         // debug($user);exit;
         // $user->email = $request['email'];
         // $user->name = $request['name'];
         // $user->lastname = $request['lastname'];
         // $user->password = '123456';
         $user->save();
      }
      $this->set([]);
   }

   public function edit($id)
   {
      $this->set([
         'id' => $id
      ]);
   }

   public function users()
   {
      $users = $this->Users->find();

      $this->set([
         'users' => $users
      ]);
   }

}