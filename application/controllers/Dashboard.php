<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed
 * for all logged in users
 */
class Dashboard extends MY_Controller {

    protected $access = array('SuperAdmin','Admin', 'User');

	function __construct()
    {
        parent::__construct();

		$this->load->model('Master');
    }


	public function index()
	{
    $minggu_ke= $this->weekNumberOfMonth(date('Y-m-d'));
    
	$firstWeekDates = array();
    $lastWeekDates = array();
    $t = date("t");
		for($i = 1; $i <= $t; $i++){
      $hari = date("N",strtotime(date('Y-m-'.$i)));
        if( $hari == 1) {
              $firstWeekDates[] = date('Y-m-'.$i);
        }
        if( $hari == 7) {
              $lastWeekDates[] = date('Y-m-'.$i);
        }
		}

		if($minggu_ke == 0 ) {
				$tujuh_hari = mktime(0,0,0,date("m",strtotime($lastWeekDates[$minggu_ke])),date("d",strtotime($lastWeekDates[$minggu_ke]))-6,date("Y",strtotime($lastWeekDates[$minggu_ke])));
				$dari = date("Y-m-d", $tujuh_hari);
			}else{
				$dari = $firstWeekDates[$minggu_ke-1];
			}
		if($minggu_ke == 4 ) {
			$sampai =  date("Y-m-t", strtotime(date('Y-m-d')));
		}else{
		    
		   //if ((is_null($lastWeekDates[$minggu_ke]))){
		     //   $sampai =  date('Y-m-t', strtotime($dari));
		   // }else {
		      //  $sampai = is_null($lastWeekDates[$minggu_ke]);
		        $sampai = $lastWeekDates[$minggu_ke];
		    //}
			
			
			
		}
			
		$data = array(
			'dari' => $dari,
			'sampai' => $sampai,
		);

		$jadwal['query']= $this->Master->getcalendar();
		$notif['query']= $this->Master->getnotif();
		$inbound['query']= $this->Master->getinbound($data);
        //$inbound['query']= $this->Master->getinbound();

//$inbound = null;

		$this->load->view('header', $notif);
		$this->load->view('index', $inbound);
		$this->load->view('footer',$jadwal);

	}

  function weekNumberOfMonth($date) {
    $awalbulan = date("Y-m-01");
    $mingguAwalBulan = date('W',strtotime($awalbulan));
    $awalke =$date;
    $minggukeBulan = date('W',strtotime($awalke));
    $mingguKe = $minggukeBulan - $mingguAwalBulan ;
    
    return $mingguKe;
  }

	public function notif(){
		$level = $this->session->userdata('role');

		if($level!='User'){
			$jumlah = $this->Master->getcountnotif();

			echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>";
			echo "<i class='fa fa-bell-o'></i>";
			echo "<span class='label label-warning'>".$jumlah."</span> </a>";
			echo "<ul class='dropdown-menu'>";
			echo "<li class='header'>You have ". $jumlah ." notifications</li>";
			echo "<li>";
			echo "<ul class='menu'>";



			foreach($this->Master->getnotif() as $row){

				echo "<li>";
				echo "<a href='".base_url()."tschedule/update/". $row->ID ."'>";
				echo "<i class='fa fa-warning text-yellow' href='#'></i>Request ";
				echo $row->pengguna;
				echo " Tanggal: ".date("d/m/Y",strtotime($row->Tanggal));
				echo "</a>";
				echo "</li>";
			}


			 echo "</ul></li><li class='footer'><a href='#'>View all</a></li></ul>";
		}

	}



}
