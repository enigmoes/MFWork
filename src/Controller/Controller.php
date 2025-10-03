<?php
declare(strict_types = 1);

class Controller
{
   public $request;
   public $model;
   public $layout;
   public $template;
   public $helper;

   //Controlador principal
   public function __construct()
   {
      // Inicamos session
      Session::start();

      // Establecemos request
      $this->request = new Request();

      // Obtenemos ficheros de modelos
      $models = array_diff(scandir(MODEL_PATH), ['..', '.']);
      // Recorrer ficheros, incluimos e instanciamos atributos dinámicos
      foreach ($models as $model) {
         // Importamos modelo
         require_once MODEL_PATH . $model;
         // Eliminar extension
         $className = explode('.', $model)[0];
         // Instanciamos atributos dinámico
         $this->$className = new $className;
      }

      // Set view
      $backTrace = debug_backtrace();
      $this->template = end($backTrace)['object']->action;

      // Set default layout
      $this->setLayout();
   }

   // Set layout
   public function setLayout($layout = '')
   {
      //Si no existe layout
      if (empty($layout)) {
         $this->layout = LAYOUT_PATH . 'default' . TEMPLATE_EXT;
      } else {
         if (is_file(LAYOUT_PATH . $layout)) {
            $this->layout = LAYOUT_PATH . basename($layout . TEMPLATE_EXT);
         } else {
            trigger_error('No existe el layout');
         }
      }
   }

   // Funcion que carga una vista con los datos pasados
   // public function view($view, $data = [], $layout = '')
   public function set($data = [])
   {
      // Clase desde la que se llama a la vista
      $className = str_replace(CONTROLLER_PART, '', get_called_class());

      if (is_null($this->template)) {
         $this->template = 'index';
      }

      // Incluimos la clase helper que nos valdra para redireccionar las peticiones de una forma mas amigable
      require_once CORE_VIEW_PATH . 'Helper' . CONTROLLER_EXT;
      $this->Helper = new Helper($className, $this->template, $data);

      if (isset($data['title'])) {
         ${'title'} = $data['title'];
      } else {
         ${'title'} = ucfirst($className). ' - ' .ucfirst($this->template);
      }

      // Establecemos request
      // $this->request = new Request();

      // Incluimos la vista seleccionada
      require_once $this->layout;
   }

   // Funcion que redirecciona a un controlador y a una accion
   public function redirect($route)
   {
      header('Location: ' . $route);
   }
}