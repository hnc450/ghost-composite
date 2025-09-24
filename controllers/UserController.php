<?php 
  namespace Controller;
  class UserController extends \Controller\BaseController
  {
      private string $nameRegex = "/^[a-zA-Z\s'-]+$/";
      private string $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
      private string $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
   
      public function __construct($model)
      {
        parent::__construct($model);
      }
      
    public function deleteAccount($id){
     
       if($this->model->getUserById($id) === null){
            $this->jsonResponse([
                'status' => 404,
                'message' => 'Utilisateur non trouvé'
            ]);

            return;
        }

        $this->model->deleteUser($id);

        $this->jsonResponse([
            'status' => 200,
            'message' => 'Utilisateur supprimé avec succès'
        ]);
        return;
    }

    public function updateAccount($id, $datas = []){

        if(!$this->isNotEmpty($datas)){
            $this->jsonResponse([
                'status' => 400,
                'message' => 'Aucune donnére à mettre à jour'
            ]);
            return;
        }

        if($this->model->getUserById($id) === false){

            $this->jsonResponse([
                'status' => 404,
                'message' => 'Utilisateur non trouvé'
            ]);
            return;
        }

        $this->model->updateUser($id, $datas);

        $this->jsonResponse([
            'status' => 200,
            'message' => 'Mise à jour réussie'
        ]);
        return;
    }
    public function sign(array $datas = [], array $fields = [])
    {
      if (!$this->isNotEmpty($datas) || !$this->verifyFields($datas, $fields)) {
           $this->jsonResponse([
              'status' => 400,
              'message' => 'Tous les champs sont requis'
          ]);
           return;
      }

     // Validation des longueurs
      if (
          !$this->valideLength($datas['name'], 6, 16) ||
          !$this->valideLength($datas['mail'], 6, 64) ||
          !$this->valideLength($datas['password'], 6, 64)
      ) {
          $this->jsonResponse([
              'status' => 400,
              'message' => 'Longueur incorrecte'
          ]);
          return;
      }

      // Validation des formats
      $validators = [
          ['value' => $datas['name'], 'regex' => $this->nameRegex, 'field' => 'Nom invalide'],
          ['value' => $datas['mail'], 'regex' => $this->emailRegex, 'field' => 'Email invalide'],
          ['value' => $datas['password'], 'regex' => $this->passwordRegex, 'field' => 'Mot de passe invalide']
      ];

     foreach ($validators as $validator) {
         if (!$this->matcherString($validator['value'], $validator['regex'])) {
             $this->jsonResponse([
                 'status' => 400,
                 'message' => $validator['field']
             ]);
             return;
         }
     }

     // Si tout est valide, tu peux continuer ici (ex: insertion en base)
     $this->model->createUser($datas['name'], $datas['mail'], $datas['password']);

     $this->jsonResponse([
         'status' => 200,
         'message' => 'Inscription réussie'
     ]);
    }


    public function login($datas = [] , $fields = [])
    {
       if (!$this->isNotEmpty($datas) || !$this->verifyFields($datas, $fields)) {
             $this->jsonResponse([
                'status' => 400,
                'message' => 'Tous les champs sont requis'
            ]);
        }

       if(
          !$this->valideLength($datas['mail']) ||
          !$this->valideLength($datas['password'])
        ) {
          $this->jsonResponse([
              'status' => 400,
              'message' => 'Longueur incorrecte'
          ]);
        }

        $validators = [
            ['value' => $datas['name'], 'regex' => $this->nameRegex, 'field' => 'Nom invalide'],
            ['value' => $datas['mail'], 'regex' => $this->emailRegex, 'field' => 'Email invalide'],
            ['value' => $datas['password'], 'regex' => $this->passwordRegex, 'field' => 'Mot de passe invalide']
        ];

        foreach ($validators as $validator) {
          if (!$this->matcherString($validator['value'], $validator['regex'])) {
              $this->jsonResponse([
                  'status' => 400,
                  'message' => $validator['field']
              ]);
              return;
          } 
        }
        $user = $this->model->authenticate($datas['mail'], $datas['password']);

        if ($user) {

            $this->jsonResponse([
                'status' => 200,
                'message' => 'Connexion réussie',
                'user' => $user
            ]);
        }

        else {

            $this->jsonResponse([
                'status' => 401,
                'message' => 'Email ou mot de passe incorrect'
            ]);

        }
     
    }
    
  }
?>