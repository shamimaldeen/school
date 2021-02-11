<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('manager'))
{
	function manager($total_rows, $per_page_item) {
    $config['per_page']        = $per_page_item;
    $config['num_links']       = 2;
    $config['total_rows']      = $total_rows;
    $config['full_tag_open']   = '<ul class="pagination justify-content-end">';
    $config['full_tag_close']  = '</ul>';
    $config['prev_link']       = '<span class="page-link">Previous</span>';
    $config['prev_tag_open']   = '<li class="page-item">';
    $config['prev_tag_close']  = '</li>';
    $config['next_link']       = '<span class="page-link">Next</span>';
    $config['next_tag_open']   = '<li class="page-item">';
    $config['next_tag_close']  = '</li>';
    $config['cur_tag_open']    = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']   = '<span class="sr-only">(current)</span></span></li>';
    $config['num_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']   = '</span></li>';
    // $config['first_tag_open']  = '<span class="page-link">';
    // $config['first_tag_close'] = '</span>';
    // $config['last_tag_open']   = '<span class="page-link">';
    // $config['last_tag_close']  = '</span>';
    // $config['first_link']      = 'First';
    // $config['last_link']       = 'Last';
		$config['first_link'] = false;
		$config['last_link'] = false;
    return $config;
  }
}
if ( ! function_exists('get_settings'))
{

    function get_settings($type)
    {
        $CI = get_instance();
        $CI->load->database();
        $des = $CI->db->get_where('settings', array('type' => $type))->row()->description;
        return $des;
    }
}

if ( ! function_exists('get_invoice_no'))
{

    function get_invoice_no($id, $digit) //1105, 6
    {
        $diff = (strlen($id)<$digit) ? $digit - strlen($id) : 0;
        return str_pad($id, $diff, '0', STR_PAD_LEFT);
    }
}

if ( ! function_exists('get_sectionName'))
{

    function get_sectionName($section_id){
        $CI = get_instance();
        $CI->load->database();
        $q= $CI->db->get_where('section', ['section_id'=>$section_id]);
        if ($q->num_rows() > 0){
            $data = $q->row();
            return $data->name . '('.$data->nick_name.')';
        }
        return null;
    }
}



/**********************************Convert Number in Word**********************************/
if ( ! function_exists('convertNumber')) {

    function convertNumber($number)
    {
        list($integer, $fraction) = explode(".", (string)$number);

        $output = "";

        if ($integer{0} == "-") {
            $output = "Negative ";
            $integer = ltrim($integer, "-");
        } else if ($integer{0} == "+") {
            $output = "Positive ";
            $integer = ltrim($integer, "+");
        }

        if ($integer{0} == "0") {
            $output .= "zero";
        } else {
            $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
            $group = rtrim(chunk_split($integer, 3, " "), " ");
            $groups = explode(" ", $group);

            $groups2 = array();
            foreach ($groups as $g) {
                $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});
            }

            for ($z = 0; $z < count($groups2); $z++) {
                if ($groups2[$z] != "") {
                    $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11]{0} == '0'
                            ? " and "
                            : ", "
                        );
                }
            }

            $output = rtrim($output, ", ");
        }

        if ($fraction > 0) {
            $output .= " point";
            for ($i = 0; $i < strlen($fraction); $i++) {
                $output .= " " . convertDigit($fraction{$i});
            }
        }

        return $output;
    }

}
function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " Decillion";
        case 10:
            return " Nonillion";
        case 9:
            return " Octillion";
        case 8:
            return " Septillion";
        case 7:
            return " Sextillion";
        case 6:
            return " Quintrillion";
        case 5:
            return " Quadrillion";
        case 4:
            return " Trillion";
        case 3:
            return " Billion";
        case 2:
            return " Million";
        case 1:
            return " Thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " Hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "Ten";
            case "2":
                return "Twenty";
            case "3":
                return "Thirty";
            case "4":
                return "Forty";
            case "5":
                return "Fifty";
            case "6":
                return "Sixty";
            case "7":
                return "Seventy";
            case "8":
                return "Eighty";
            case "9":
                return "Ninety";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "Eleven";
            case "2":
                return "Twelve";
            case "3":
                return "Thirteen";
            case "4":
                return "Fourteen";
            case "5":
                return "Fifteen";
            case "6":
                return "Sixteen";
            case "7":
                return "Seventeen";
            case "8":
                return "Eighteen";
            case "9":
                return "nineteen";
        }
    } else
    {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "Twenty $temp";
            case "3":
                return "Thirty $temp";
            case "4":
                return "Forty $temp";
            case "5":
                return "Fifty $temp";
            case "6":
                return "Sixty $temp";
            case "7":
                return "Seventy $temp";
            case "8":
                return "Eighty $temp";
            case "9":
                return "Ninety $temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "Zero";
        case "1":
            return "One";
        case "2":
            return "Two";
        case "3":
            return "Three";
        case "4":
            return "Four";
        case "5":
            return "Five";
        case "6":
            return "Six";
        case "7":
            return "Seven";
        case "8":
            return "Eight";
        case "9":
            return "Nine";
    }
}
/*********************************End Convert Number in Word**********************************/