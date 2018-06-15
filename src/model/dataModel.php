<?php

namespace app\model;

use \PDO as PDO;
use app\model\DbModel as DbModel;

class DataModel
{

    private $dbh;
    private $config;

    public function __construct($conf = [])
    {   
        // Get config data
        $this->config = $conf;

        // Connect to db
        $dbModel = new DbModel($this->config);
        $this->dbh = $dbModel->getDbh();
    }

    public function getAllData($filter = '')
    {
        $doramaData = $this->dbh->select()->from('dorama');

        if($filter != '') {
            // var_dump($filter);die();
            foreach($filter as $key => $value) {
                if($value != 'none') {
                    $doramaData->where($key, '=', $value);
                }
            }
        }

        $stmt = $doramaData->execute();
        $data = $stmt->fetchAll();

        foreach($data as $key => $value) {
            $dataNew[$key] = [
                'id' => $value['id_dorama'],
                'dorama_name' => $value['dorama_name'],
                'dorama_original_name' => $value['dorama_original_name'],
                'country' => current($this->getCountry($value['id_country'])),
                'channel' => current($this->getChannel($value['id_channel'])),
                'series_count' => $value['series_count'],
                'series_duration' => $value['series_duration'] . ' min',
                'status' => current($this->getStatus($value['id_status'])),
                'producer' => current($this->getProducer($value['id_producer'])),
                'genre' => current($this->getGenre($value['id_genre'])),
                'issue_year' => $value['issue_year'],                
            ];
        } 
        return $dataNew;
    }

    public function getCountry($id = '')
    {
        $doramaData = $this->dbh->select()->from('country');
        $id != '' ? $doramaData = $this->dbh->select(['country_name'])->from('country')->where('id_country', '=', $id) : '';
        $stmt = $doramaData->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getGenre($id = '')
    {
        $doramaData = $this->dbh->select()->from('genre');
        $id != '' ? $doramaData = $this->dbh->select(['genre_name'])->from('genre')->where('id_genre', '=', $id) : '';
        $stmt = $doramaData->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getProducer($id = '')
    {
        $doramaData = $this->dbh->select()->from('producer');
        $id != '' ? $doramaData = $this->dbh->select(['producer_name'])->from('producer')->where('id_producer', '=', $id) : '';
        $stmt = $doramaData->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getStatus($id = '')
    {
        $doramaData = $this->dbh->select()->from('status');
        $id != '' ? $doramaData = $this->dbh->select(['status_name'])->from('status')->where('id_status', '=', $id) : '';
        $stmt = $doramaData->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getChannel($id = '')
    {
        $doramaData = $this->dbh->select()->from('сhannel');
        $id != '' ? $doramaData = $this->dbh->select(['сhannel_name'])->from('сhannel')->where('id_channel', '=', $id) : '';
        $stmt = $doramaData->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function insertNewDorama($data)
    {
        $doramaData = $this->dbh->insert([
          'dorama_name', 'dorama_original_name','id_country','id_channel','series_count','series_duration','id_status','id_producer','id_genre','issue_year'])
          ->into('dorama')
          ->values([$data['Dorama']['name'],$data['Dorama']['original-name'],$data['Dorama']['country'],$data['Dorama']['channel'],$data['Dorama']['series-count'],$data['Dorama']['series-duration'],$data['Dorama']['status'],$data['Dorama']['producer'],$data['Dorama']['genre'],$data['Dorama']['issue-year']]);
        $stmt = $doramaData->execute(false);
    }

    public function getDoramaById($id)
    {
        $doramaData = $this->dbh->select()->from('dorama')->where('id_dorama', '=', $id);
        $stmt = $doramaData->execute();
        $data = $stmt->fetch();
        return $data;
    }

    public function updateDorama($data)
    {
        $doramaData = $this->dbh->update([
            'dorama_name' => $data["Dorama"]['name'],
            'dorama_original_name' => $data["Dorama"]['original-name'],
            'id_country' => $data["Dorama"]['country'],
            'id_channel' => $data["Dorama"]['channel'],
            'series_count' => $data["Dorama"]['series-count'],
            'series_duration ' => $data["Dorama"]['series-duration'],
            'id_status' => $data["Dorama"]['status'],
            'id_producer' => $data["Dorama"]['producer'],
            'id_genre' => $data["Dorama"]['genre'],
            'issue_year' => $data["Dorama"]['issue-year']
        ])->table('dorama')->where('id_dorama', '=', $data["Dorama"]['id']);
        $stmt = $doramaData->execute();
    }

    public function sotrDoramas($id)
    {
        $doramaData = $this->dbh->delete()->from('dorama')->where('id_dorama', '=', $id);
        $stmt = $doramaData->execute();
    }

    public function deleteDorama($id)
    {
        $doramaData = $this->dbh->delete()->from('dorama')->where('id_dorama', '=', $id);
        $stmt = $doramaData->execute();
    }

}