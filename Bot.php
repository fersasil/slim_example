<?php
require_once 'vendor/autoload.php';

define("BARRACK", 6);
define("ACADEMY", 4);
define("TRADING_PORT", 3);
define("WALL", 8);
define("WAREAHOUSE", 7);

class Bot {
  private $client;
  private $email;
  private $password;
  private $server;
  private $country;
  private $base_url;
  private $city_id;
  private $headers;
  private $actionRequest;
  private $server_number;
  private $island_id;

  function __construct ($email, $password, $server_number, $proxy = "" ){
      $this->client = new \GuzzleHttp\Client(['cookies' => true, 'proxy' => $proxy]);

      $this->headers = array();
      $this->headers[] = 'Authority: lobby.ikariam.gameforge.com';
      $this->headers[] = 'Accept: application/json';
      $this->headers[] = 'Origin: https://lobby.ikariam.gameforge.com';
      $this->headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36';
      $this->headers[] = 'Content-Type: application/json';
      $this->headers[] = 'Sec-Fetch-Site: same-origin';
      $this->headers[] = 'Sec-Fetch-Mode: cors';
      $this->headers[] = 'Referer: https://lobby.ikariam.gameforge.com/pt_BR/';
      $this->headers[] = 'Accept-Encoding: gzip, deflate, br';
      $this->headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
      $this->headers[] = 'Cookie: pc_idt=AJgBxM6f-RNtY0DD02exhCvW7eFulOk3ul4R32dkET0rlQ6z3pvyxuc982CX40ZjDi8JZE6LIb5uaS7vRlK4Sn4c1Bcxj74-2IGGpQEZUpYzwXZdSRUA_s9p9RwX8FewOvDQsif5EqHdsQT32DhHfUA006nZvJ6P4RDj6w; never_logged_in=false';

      $this->email = $email;
      $this->password = $password;
      $this->server_number = $server_number;
      $this->country = "br";


      $this->login();
      $this->setBaseUrl();
  }

  function login(){
    $data = [
        "credentials" => [
            "email" => $this->email,
            "password" => $this->password,
        ],
        "language" => "br",
        "kid" => "",
        "autoLogin" => "false"
    ];

    $response = $this->client->request('POST', 'https://lobby.ikariam.gameforge.com/api/users', [
        "headers" => $this->headers,
        "form_params" => $data
    ]);
    
    
    $response = $this->client->request('GET', 'https://lobby.ikariam.gameforge.com/api/users/me/accounts');
    
    $response_array = json_decode($response->getBody()->getContents());
    $url = "";

    foreach ($response_array as $key => $ikaria_account) {
      if($ikaria_account->server->number == $this->server_number){
        $url = "https://lobby.ikariam.gameforge.com/api/users/me/loginLink?id=$ikaria_account->id&server[language]=br&server[number]=$this->server_number&clickedButton=account_l";
        break;
      }
    }
    
    $response = $this->client->request('GET', $url);
    
    $json_response  = $response->getBody()->getContents();
    
    $login_url = json_decode($json_response)->url;
    
    
    $response = $this->client->request('GET', $login_url);
    
    $body  = $response->getBody()->getContents();
    $this->getActionRequest($body);
    $this->get_city_id($body);
    $this->get_island_id($body);
  }

  private function get_city_id($body){
    preg_match('/currentCityId"?:\s*(.*?),/', $body, $matches);
    $this->city_id = $matches[1]; 
  }

  private function get_island_id($body){
    preg_match('/islandId"?:\s*"(.*?)"/', $body, $matches);
    $this->island_id = $matches[1]; 
  }

  private function getActionRequest($body){
    preg_match('/actionRequest"?:\s*"(.*?)"/', $body, $matches);
    
    $this->actionRequest = $matches[1];
  }

  function getToken(){
    return $this->actionRequest;
  }

  public function build($building, $position){
		$params['get'] = array(
			'action' => 'CityScreen',
			'function' => 'build',
			'cityId' => $this->city_id,
			'position' => $position,
			'building' => $building,
			'actionRequest' => $this->actionRequest
		);

		$this->fetchPage($params);
  }

  private function fetchPage($params = null){
    $uri = http_build_query($params['get']);
    $url = $this->base_url ."?". $uri;
    
    $response = $this->client->request('GET', $url);
    
    $body = $response->getBody()->getContents();
    
    $this->getActionRequest($body);
  }
  
  private function setBaseUrl(){
		$this->base_url = "https://s$this->server_number-$this->country.ikariam.gameforge.com/";
  }
  
  public function speedBuilding($level, $position){
		$params['get'] = array(
			'action' => 'Premium',
			'function' => 'buildingSpeedup',
			'cityId' => $this->city_id,
			'position' => $position,
			'level' => $level,
			'actionRequest' => $this->actionRequest
		);

	
    $this->fetchPage($params);
  }

  public function rewardShown(){
		$params['get'] = array(
			'action' => 'TutorialOperations',
			'function' => 'rewardShown',
			'actionRequest' => $this->actionRequest
		);

		$this->fetchPage($params);
  }
  
  public function buildUnits($position, $number){
		$params['get'] = array(
			'301'=>'0',
			'302'=>'0',
			'303'=>'0',
			'304'=>'0',
			'305'=>'0',
			'306'=>'0',
			'307'=>'0',
			'308'=>'0',
			'309'=>'0',
			'310'=>'0',
			'311'=>'0',
			'312'=>'0',
			'313'=>'0',
			'315'=> $number,
			'action' => 'CityScreen',
			'function' => 'buildUnits',
			'cityId' => $this->city_id,
			'position' => $position,
			'actionRequest' => $this->actionRequest
		);

		$this->fetchPage($params);
  }
  
  public function doResearch($research){
		
		$params['get'] = array(
			'action' => 'Advisor',
			'function' => 'doResearch',
			'type' => $research,
			'actionRequest' => $this->actionRequest
		);

		$this->fetchPage($params);
	}

	public function hireSc($position, $number){
		$params['get'] = array(
			'action' => 'IslandScreen',
			'function' => 'workerPlan',
			'cityId' => $this->city_id,
			's' => $number,
			'screen' => 'academy',
			'position' => $position,
			'actionRequest' => $this->actionRequest
		);

		$this->fetchPage($params);
	}


	public function viewPremium(){
		$params['get'] = array(
			'view' => 'premium',
			'linkType' => '1',
		);

		$this->fetchPage($params);
  }
  
  public function increaseTransporter($position){
		$params['get'] = array(
			'action' => 'CityScreen',
			'function' => 'increaseTransporter',
			'cityId' => $this->city_id,
			'position' => $position,
			'activeTab' => 'tabBuyTransporter',
			'actionRequest' => $this->actionRequest
		);

		$this->fetchPage($params);
	}
  
  public function setWorkers($number){
		$params['get'] = array(
			'action' => 'IslandScreen',
			'function' => 'workerPlan',
			'type' => 'resource',
			'currentIslandId' => $this->island_id,
			'cityId' => $this->city_id,
			'screen' => 'resource',
			'rw' => $number,
			'actionRequest' => $this->actionRequest
		);

		$this->fetchPage($params);
  }
  
  public function upgradeBuilding($position, $level){
		$params['get'] = array(
			'action' => 'CityScreen',
			'function' => 'upgradeBuilding',
			'cityId' => $this->city_id,
			'position' => $position,
			'level' => $level,
			'actionRequest' => $this->actionRequest
		);

		$this->fetchPage($params);
  }
  
  public function attackBarbarian(){
		
		$params['get'] = array(
			'action' => 'transportOperations',
			'function' => 'attackBarbarianVillage',
			'islandId' => $this->island_id,
			'destinationCityId'=> '0',
			'cargo_army_315_upkeep' => '1',
			'cargo_army_315' => '2',
			'transporter' => '2',
			'barbarianVillage' => '1',
			'actionRequest' => $this->actionRequest
		);

    $this->fetchPage($params);
	}


  // SPECIAL FUNCTION TO WEB
  // The order must be preserved while calling these functions
  
  function build_barrack(){
    $this->build(BARRACK, $position = 6);

    $this->speedBuilding($level = 0, $position = 6);
    $this->speedBuilding($level = 0, $position = 6);
    $this->rewardShown();

    //Contratar lanceiros
    $this->buildUnits($position = 6, $number = 3);
  }

  function assign_saw_mill_workers(){
    //Contratar madeireiros
    $this->setWorkers($number = 10);
    $this->rewardShown();
  } 

  function build_academy(){
    //construir academia
    $this->build(ACADEMY, $position = 4);
    $this->rewardShown();
    $this->speedBuilding($level = 0, $position = 4);
    $this->speedBuilding($level = 0, $position = 4);


    //Fazer pesquisa
    $this->doResearch($research = 'economy');
    $this->rewardShown();

    //Contratar cientistas
    $this->hireSc($position = 4, $number = 4);
    $this->rewardShown();

  }

  function build_wareahouse(){
    //Criar armazen
    $this->build(WAREAHOUSE, $position = 7);
    $this->rewardShown();
    $this->speedBuilding($level = 0, $position = 7);
    $this->speedBuilding($level = 0, $position = 7);
    $this->rewardShown();
    $this->rewardShown();

    //Ter construido o quartel/Recompensa
    $this->rewardShown();
  }

  function build_wall(){
    //Criar muraria
    $this->build(WALL, $position = 14);

    $this->speedBuilding($level = 0, $position = 14);
    $this->speedBuilding($level = 0, $position = 14);
    $this->rewardShown();
    $this->rewardShown();
  }

  /**
   * IMPORTANT
   * NEXT FUNCTION SHOULD HAVE A DELAY OF 
   * 120 SECONDS!
   * USE THIS, NEXT USE sleep(120)
   * THEN THE NEXT FUNCTION!
   */

  function build_port(){
    //Contruir porto demora 2 min pra poder encurtar
    $this->build(TRADING_PORT, $position = 1);
    $this->rewardShown();
  }

  function build_boat(){
    $this->speedBuilding($level = 0, $position = 1);
    $this->speedBuilding($level = 0, $position = 1);

    //Comprar barco
    $this->increaseTransporter($position = 1);
    $this->rewardShown();
  }

  function upgrade_wareahouse(){
    //Aumentar armazem 13 minutos para ficar pronto, espera de 8 min -> pode ser contornado
    $this->upgradeBuilding($position = 7, $level = 2);
    $this->rewardShown();
  }

  function attack_barbarians_and_plus(){
    //Atacar barbaros

    $this->attackBarbarian();
    $this->rewardShown();

    //Olhar ika plus
    $this->viewPremium();
    $this->rewardShown(); 
  }
}

$bot = new Bot("guilhermefsds@gmail.com", "3864", "4");


echo "Quartel\n";
$bot->build_barrack();
echo "Madereira\n";
$bot->assign_saw_mill_workers();
echo "Academia\n";
$bot->build_academy();
echo "Armazem\n";
$bot->build_wareahouse();
echo "Muralha\n";
$bot->build_wall();
echo "Portp\n";
$bot->build_port();
echo "Pausa 120s\n";
sleep(120);
echo "Comprar barco\n";
$bot->build_boat();
echo "update armazem\n";
$bot->upgrade_wareahouse();
echo "Atacar barbaros\n";
$bot->attack_barbarians_and_plus();