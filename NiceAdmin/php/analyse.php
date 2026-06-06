<?php
    class Analyse{
        private $username;
        private $nbr_of_products;
        private $nbr_of_taxes;
        private $nbr_of_services;
        private $nbr_of_depenses;
        private $bag_table;
        private $bag_table_num_rows;
        public function __construct(){
        }
        public function set_depenses_statistics($username,$array){
            $this->nbr_of_depenses=0;
            $this->nbr_of_products=0;
            $this->nbr_of_services=0;
            $this->nbr_of_taxes=0;
            $this->nbr_of_depenses=0;
            foreach($array as $ligne){
                $this->nbr_of_depenses++;
                if($ligne['type']=='produits' ){$this->nbr_of_products++;}
                if($ligne['type']=='services' ){$this->nbr_of_services++;}
                if($ligne['type']=='taxes' ){$this->nbr_of_taxes++;}
            }
        }
        public function get_nbr_of_products() {  return $this->nbr_of_products;}
        public function get_nbr_of_taxes()    {  return $this->nbr_of_taxes;}
        public function get_nbr_of_services() {  return $this->nbr_of_services;}
        public function get_nbr_of_depenses() {  return $this->nbr_of_depenses;}
        public function set_bag_table($result){  $this->bag_table = $result;}
        public function get_bag_table()       {  return $this->bag_table;}
        public function get_bag_table_num_rows() {  return $this->bag_table_num_rows;}
        public function set_bag_table_num_rows($connexion){
            $res=$this->get_bag_table();
            $this->bag_table_num_rows = count($res);
        }
        public function get_max_value_bag($connexion,$username){
            $pipeline = [
                ['$match' => ['username' => $username]],
                ['$group' => ['_id' => null, 'maxx' => ['$max' => '$value']]]
            ];
            $cursor = $connexion->bag->aggregate($pipeline);
            foreach ($cursor as $doc) {
                return $doc['maxx'];
            }
            return 0;
        }
    }
    function give_max($l){
        if( $l['rest_du_cheque_final'] >= $l['epargne'] ){
            return $l['rest_du_cheque_final'];
        }else {return $l['epargne'];}
    }
    class Chart{
    }
?>