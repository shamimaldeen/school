<?php
$pending_book_requests = $this->db->get_where('book_request', array('status' => 0))->num_rows();

$this->db->select_sum('total_copies', 'total_copies');
$query = $this->db->get('book');
$result = $query->result();
$total_copies = $result[0]->total_copies;

$this->db->select_sum('issued_copies', 'issued_copies');
$query = $this->db->get('book');
$result = $query->result();
$issued_copies = $result[0]->issued_copies;
?>

<hr />

<div class="row">

    <div class="col-md-3">
        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-users"></i></div>
            <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('teacher');?>"
                 data-postfix="" data-duration="800" data-delay="0">0</div>
            <h3>Total Teachers</h3>
        </div>

    </div>
    <div class="col-md-3">
        <div class="tile-stats tile-red">
            <div class="icon" style="margin-bottom: 20px;"><i class="entypo-book"></i></div>
            <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('book');?>" 
            		data-postfix="" data-duration="1500" data-delay="0">0</div>
            <h3><?php echo get_phrase('total_books');?></h3>
        </div>
        
    </div>
    <div class="col-md-3">
        <div class="tile-stats tile-blue">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <?php
            $check	=	array('timestamp' => strtotime(date('Y-m-d')) , 'status' => '1','student_id'=>$this->session->userdata("student_id"));
            $query = $this->db->get_where('attendance' , $check);
            $present_today		=	$query->num_rows();
            ?>
            <div class="num" data-start="0" data-end="<?php echo $present_today;?>"
                 data-postfix="" data-duration="500" data-delay="0">0</div>

            <h3><?php echo get_phrase('attendance');?></h3>
            <p>Total Manthly Attendance of <?= date('F')?></p>
        </div>
        
    </div>

    <div class="col-md-3">

        <div class="tile-stats tile-blue">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <?php
            $check	=	array('timestamp' => strtotime(date('Y-m-d')) , 'status' => '2','student_id'=>$this->session->userdata("student_id"));
            $query = $this->db->get_where('attendance' , $check);
            $present_today		=	$query->num_rows();
            ?>
            <div class="num" data-start="0" data-end="<?php echo $present_today;?>"
                 data-postfix="" data-duration="500" data-delay="0">0</div>

            <h3><?php echo get_phrase('absent');?></h3>
            <p>Total Manthly Absent of <?= date('F')?></p>
        </div>
        
    </div>
	
</div>

  












