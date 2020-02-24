<?php 
	// crear conexion con oracle
	class Conexion{ 
		private $conexion;
		public function __construct(){}	

		//guarda en variable de conexion
		public function establecerConexion(){
			$this->conexion = oci_connect("DB_SPOTIFY", "oracle", "localhost/xe");
			if (!$this->conexion) {    
				  $m = oci_error();    
				  echo $m['message'], "n";    
				  exit; 
			} else {    
				  //echo "Conexión con éxito a Oracle!". '<br>'; 
				  //echo "Conexion hecha a la base de datos de SPOTIFY<br>";
			} 
		}

		//cerrar conexion de la BD
		public function cerrarConexion(){
			oci_close($this->conexion);
			//echo "<br>Conexion cerrada";
		}

		//recibir consulta de SQL
		public function ejecutarInstruccion($sql){
			return oci_parse($this->conexion, $sql);
		}

		//retornar resultado de arreglo
		public function obtenerFila($resultado){
			return oci_fetch_array($resultado, OCI_BOTH);
		}

		//retorna cantidad de registros afectados en la consulta
		public function cantidadRegistros($resultado){
			return oci_num_rows($resultado);
		}

		//libera recursos
		public function liberarResultado($resultado){
			oci_free_statement($resultado);
		}
 	}
?>