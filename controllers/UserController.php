<?php 
  namespace Controller;
  class UserController extends \Controller\BaseController
  {
    private string $nameRegex = "/^[a-zA-Z\s'-]+$/";
    private string $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    private string $passwordRegex = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/";
   
    public function __construct($model)
    {
      parent::__construct($model);
    }
      
    public function deleteAccount($id){
      
       if($this->model->getUserById($id) === false){
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
          !$this->valideLength($datas['nom'], 6, 16) ||
          !$this->valideLength($datas['email'], 6, 64) ||
          !$this->valideLength($datas['mot_de_passe'], 6, 64)
      ) {
          $this->jsonResponse([
              'status' => 400,
              'message' => 'Longueur incorrecte'
          ]);
          return;
      }

      // Validation des formats
      $validators = [
          ['value' => $datas['nom'], 'regex' => $this->nameRegex, 'field' => 'Nom invalide'],
          ['value' => $datas['email'], 'regex' => $this->emailRegex, 'field' => 'Email invalide'],
          ['value' => $datas['mot_de_passe'], 'regex' => $this->passwordRegex, 'field' => 'Mot de passe invalide']
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

   
     if(count($this->model->getUserByEmail($datas['email'])) > 0)
     {
        // arrete tout si l utilisateur existe
        $this->jsonResponse([
            'status' => '409',
            'message' => 'Utilisateur existant'
        ]);
        return;
     }
    // Si tout est valide, tu peux continuer ici (ex: insertion en base)
     $this->model->createUser($datas['nom'], $datas['email'], $datas['mot_de_passe']);

     $this->jsonResponse([
         'status' => 200,
         'message' => 'Inscription réussie'
     ]);
     return;
    }


    public function login($datas = [] , $fields = [])
    {
       if (!$this->isNotEmpty($datas) || !$this->verifyFields($datas, $fields)) {
             $this->jsonResponse([
                'status' => 400,
                'message' => 'Tous les champs sont requis'
            ]);
             return;
        }

       if(
          !$this->valideLength($datas['email']) ||
          !$this->valideLength($datas['mot_de_passe'])
        ) {
          $this->jsonResponse([
              'status' => 400,
              'message' => 'Longueur incorrecte'
          ]);
          return;
        }

        $validators = [
            ['value' => $datas['email'], 'regex' => $this->emailRegex, 'field' => 'Email invalide'],
            ['value' => $datas['mot_de_passe'], 'regex' => $this->passwordRegex, 'field' => 'Mot de passe invalide']
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
        $user = $this->model->authenticate($datas['email'], $datas['mot_de_passe']);

        if ($user) {

            $this->jsonResponse([
                'status' => 200,
                'message' => 'Connexion réussie',
                'user' => $user
            ]);
            return;
        }

        else {

            $this->jsonResponse([
                'status' => 401,
                'message' => 'Email ou mot de passe incorrect'
            ]);
         return;
        }
     
    }
    
  }
?>