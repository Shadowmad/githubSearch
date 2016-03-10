<?php

  class dataEntryPoint{
    private $ch;
    function dataEntryPoint(){
      header('Content-type:application/json;charset=utf-8');
      $this->ch = curl_init();
      curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($this->ch, CURLOPT_HEADER, true);
      curl_setopt($this->ch, CURLOPT_USERAGENT, "Shadowmad");
    }

    public function getSortedDataFullList($query, $sort){
      $dataFromAPI = $this->getDataFromFullListAPI($query, $sort);
      $dataToArray = json_decode($dataFromAPI, true);
      return ($this->buildOfSortedData($dataToArray));
    }

    private function prepareQueryToAPI($query){

    }
    private function getDataFromFullListAPI($query, $sort){
			curl_setopt($this->ch, CURLOPT_URL,"https://api.github.com/search/repositories?q=$query&sort=$sort&order=desc");
			$toRet = curl_exec($this->ch);
			curl_close($this->ch);
      list($header, $body) = explode("\r\n\r\n", $toRet, 2);
      return ($body);
    }
    private function buildOfSortedData($dataFromAPI){
      $sortedData = array();
      foreach ($dataFromAPI as $key => $value) {
        if(is_array($value)){
          foreach ($value as $key) {
            $issuesUrl = preg_replace("/{\/number}/", "/", $key["issues_url"]);
            array_push($sortedData, array($key["id"], $key["full_name"], $key["description"], $key["html_url"], $key["created_at"], $key["updated_at"], $key["stargazers_count"], $key["language"], $issuesUrl));
          }
        }
      }
      return ( $sortedData);
    }
  }
?>
