<?php

/**
 * You can check query out put using this
 * echo $ci->db->last_query();
 */

if (!function_exists('DisplayStatus')) {

    function DisplayStatus($val)
    {
        $str = "";
        if ($val == 0) {
            $str = "<span class='badge badge-warning'>Pending</span>";
        } elseif ($val == 1) {
            $str = "<span class='badge badge-success'>Active</span>";
        } else {
            $str = "<span class='badge badge-danger'>Inactive</span>";
        }
        return $str;
    } //end DisplayStatus function

} //end check DisplayStatus

if (!function_exists('CourseEnrollmentStatus')) {

    function CourseEnrollmentStatus($val)
    {
        $str = "";
        if ($val == 0) {
            $str = "<span class='badge badge-warning'>Pending</span>";
        } elseif ($val == 1) {
            $str = "<span class='badge badge-success'>Enrolled</span>";
        }
        return $str;
    } //end CourseEnrollmentStatus function

} //end check DisplayStatus

if (!function_exists('PublishStatus')) {

    function PublishStatus($val)
    {
        $str = "";
        if ($val == 1) {
            $str = "<span class='badge badge-primary'>Publish</span>";
        } else {
            $str = "<span class='badge badge-danger'>Pending</span>";
        }
        return $str;
    } //end PublishStatus function

} //end check PublishStatus

if (!function_exists('CourseStatus')) {

    function CourseStatus($val)
    {
        $str = "";
        if ($val == 0) {
            $str = '<span class="badge badge-danger">' . (config('constents.course_status')[0]) . '</span>';
        } elseif ($val == 1) {
            $str = '<span class="badge badge-secondary">' . (config('constents.course_status')[1]) . '</span>';
        } elseif ($val == 2) {
            $str = '<span class="badge badge-primary">' . (config('constents.course_status')[2]) . '</span>';
        } elseif ($val == 3) {
            $str = '<span class="badge badge-success">' . (config('constents.course_status')[3]) . '</span>';
        } elseif ($val == 4) {
            $str = '<span class="badge badge-warning">' . (config('constents.course_status')[4]) . '</span>';
        }
        return $str;
    } //end CourseStatus function

} //end check ActiveStatus

if (!function_exists('DefaultStatus')) {

    function DefaultStatus($val)
    {
        $str = "";
        if ($val == 1) {
            $str = "<span class='badge badge-success'>Yes</span>";
        } else {
            $str = "<span class='badge badge-danger'>No</span>";
        }
        return $str;
    } //end PublishStatus function

} //end check PublishStatus

if (!function_exists('ArchiveStatus')) {

    function ArchiveStatus($val)
    {
        $str = "";
        if ($val == 1) {
            $str = '<span class="badge badge-primary">Yes</span>';
        } else {
            $str = '<span class="badge badge-danger">No</span>';
        }
        return $str;
    } //end ArchiveStatus function

} //end check ArchiveStatus

if (!function_exists('DeleteStatus')) {

    function DeleteStatus($val)
    {
        $str = "";
        if ($val == 1) {
            $str = '<span class="badge badge-danger">Yes</span>';
        } else {
            $str = '<span class="badge badge-primary">No</span>';
        }
        return $str;
    } //end DeleteStatus function

} //end check DeleteStatus

if (!function_exists('ReadStatus')) {

    function ReadStatus($val)
    {
        $str = "";
        if ($val == 1) {
            $str = '<span class="badge badge-success">Read</span>';
        } else {
            $str = '<span class="badge badge-warning">Unread</span>';
        }
        return $str;
    } //end ReadStatus function

} //end check ReadStatus

if (!function_exists('getUserType')) {

    function getUserType($val = 0)
    {
        $str = "";
        $val = (int)$val;
        if ($val == 1) {
            $str = 'Company User';
        } elseif ($val == 2) {
            $str = 'Individual User';
        } else {
            $str = 'Implementing Partner';
        }
        return $str;
    } //end getUserType function

} //end check getUserType

if (!function_exists('InterestStatus')) {

    function InterestStatus($val = 0, $nameOnly = false)
    {
        $str = "";
        if ($val == 1) {
            $strName = "Approved";
            $str = '<span class="badge badge-success">Approved</a>';
        } else {
            $strName = "Pending";
            $str = '<span class="badge badge-warning">Pending</a>';
        }

        if ($nameOnly == true) {
            return $strName;
        } else {
            return $str;
        }
    } //end InterestStatus function

} //end check InterestStatus

if (!function_exists('ProjectStatus')) {

    function ProjectStatus($val = 0, $nameOnly = false)
    {
        $str = "";
        $val = (int)$val;

        switch ($val) {
            case 1:
                $strName = "Approved";
                $str = '<span class="badge badge-success">' . $strName . '</span>';
                break;
            case 2:
                $strName = "Not Yet Started";
                $str = '<span class="badge badge-primary">' . $strName . '</span>';
                break;
            case 3:
                $strName = "Ongoing";
                $str = '<span class="badge badge-info">' . $strName . '</span>';
                break;
            case 4:
                $strName = "Completed";
                $str = '<span class="badge badge-success">' . $strName . '</span>';
                break;
            case 5:
                $strName = "On Hold";
                $str = '<span class="badge badge-danger">' . $strName . '</span>';
                break;

            default:
                $strName = "Pending";
                $str = '<span class="badge badge-warning">' . $strName . '</span>';
                break;
        }

        if ($nameOnly == true) {
            return $strName;
        } else {
            return $str;
        }
    } //end ProjectStatus function

} //end check ProjectStatus

if (!function_exists('ProjectStatusList')) {

    function ProjectStatusList()
    {
        $project_status = array(
            '' => '--SELECT PROJECT STATUS--',
            '0' => 'Pending',
            '1' => 'Approved',
            '2' => 'Not Yet Started',
            '3' => 'Ongoing',
            '4' => 'Completed',
            '5' => 'On Hold'
        );

        return $project_status;
    } //end ProjectStatusList function

} //end check ProjectStatusList

if (!function_exists('ProjectDocStatus')) {

    function ProjectDocStatus($val = 0, $nameOnly = false)
    {
        $str = "";
        $val = (int)$val;

        switch ($val) {
            case 1:
                $strName = 'Approved';
                $str = '<span class="badge badge-success">' . $strName . '</span>';
                break;
            case 2:
                $strName = 'Reject';
                $str = '<span class="badge badge-danger">' . $strName . '</span>';
                break;

            default:
                $strName = 'Pending';
                $str = '<span class="badge badge-warning">' . $strName . '</span>';
                break;
        }
        if ($nameOnly == true) {
            return $strName;
        } else {
            return $str;
        }
    } //end ProjectDocStatus function

} //end check ProjectDocStatus

if (!function_exists('ProjectDocStatusList')) {

    function ProjectDocStatusList()
    {
        $project_status = array(
            '' => '--SELECT PROJECT STATUS--',
            '0' => 'Pending',
            '1' => 'Approved',
            '2' => 'Reject'
        );

        return $project_status;
    } //end ProjectDocStatusList function

} //end check ProjectDocStatusList

if (!function_exists('MilestoneStatus')) {

    function MilestoneStatus($val = 0, $nameOnly = false)
    {
        $str = "";
        $val = (int)$val;

        switch ($val) {
            case 0:
                $strName = 'Not Started Yet';
                $str = '<span class="badge badge-primary">' . $strName . '</span>';
                break;
            case 1:
                $strName = 'Started';
                $str = '<span class="badge badge-info">' . $strName . '</span>';
                break;
            case 2:
                $strName = 'Completed';
                $str = '<span class="badge badge-success">' . $strName . '</span>';
                break;
            case 3:
                $strName = 'Reject';
                $str = '<span class="badge badge-danger">' . $strName . '</span>';
                break;
            case 4:
                $strName = 'Completed & Approved';
                $str = '<span class="badge badge-success">' . $strName . '</span>';
                break;

            default:
                $strName = 'Not Started Yet';
                $str = '<span class="badge badge-warning">' . $strName . '</span>';
                break;
        }
        if ($nameOnly == true) {
            return $strName;
        } else {
            return $str;
        }
    } //end MilestoneStatus function

} //end check MilestoneStatus

if (!function_exists('MilestoneStatusList')) {

    function MilestoneStatusList()
    {
        $milestone_status = array(
            '' => '--SELECT MILESTONE STATUS--',
            '0' => 'Not Started Yet',
            '1' => 'Started',
            '2' => 'Completed',
            '3' => 'Reject',
            '4' => 'Completed & Approved'
        );

        return $milestone_status;
    } //end MilestoneStatusList function

} //end check MilestoneStatusList

if (!function_exists('MilestonePercentageList')) {

    function MilestonePercentageList()
    {
        $milestone_percentage = array(
            '' => '--SELECT MILESTONE PERCENTAGE--',
            '10' => '10%',
            '20' => '20%',
            '30' => '30%',
            '40' => '40%',
            '50' => '50%',
            '60' => '60%',
            '70' => '70%',
            '80' => '80%',
            '90' => '90%',
            '100' => '100%'
        );

        return $milestone_percentage;
    } //end MilestonePercentageList function

} //end check MilestonePercentageList

if (!function_exists('chkEmptyNonZero')) {

    function chkEmptyNonZero($val, $addSign = false)
    {
        $str = "";
        if ($val != "" && $val != 0) {
            $str = ($addSign == true) ? "+" . $val : $val;
        }
        return $str;
    } //end ArchiveStatus function

} //end check ArchiveStatus

if (!function_exists('RotateArray')) {
    function RotateArray($Rec)
    {
        if (count($Rec) < 4) {
            $Rec =  array_merge($Rec, $Rec);
        } else {
            RotateArray($Rec);
        }
        return $Rec;
    }
}

if (!function_exists('does_url_exists')) {
    function does_url_exists($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }
}

if (!function_exists('NotificationKey')) {

    function NotificationKey()
    {
        $key = time() + floor(rand() * 10000);
        return $key;
    } //end NotificationKey function

} //end check NotificationKey

// This function is used for
if (!function_exists('parseJsonArray')) {

    function parseJsonArray($jsonArray, $parentID = 0)
    {

        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            $returnPArray = array();
            if (isset($subArray->children)) {
                $returnSubSubArray = parseJsonArray($subArray->children, $subArray->id);
            }

            $return[] = array('id' => $subArray->id, 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }
        return $return;
    } //end parseJsonArray fucntion

} //end parseJsonArray check is exist or not

if (!function_exists('AmountINLakhs')) {

    function AmountINLakhs($val)
    {
        $value = 0;
        if (is_numeric($val) && $val != 0) {
            $value = $val / 100000;
        }
        return $value;
        /*
    if ((number < 0) || (number > 999999999)){
        return "NUMBER OUT OF RANGE!";
    }
    var Gn = floor(number / 10000000);  // Crore
    var kn = floor(number / 100000);    // Lakhs
    var Hn = floor(number / 1000);      // Thousand
    var Dn = floor(number / 100);       // Tens (deca)
    */
    } //end AmountINLakhs function

} //end check AmountINLakhs

/**
 *  Check if an array is a multidimensional array.
 *
 *  @param   array   $arr  The array to check
 *  @return  boolean       Whether the the array is a multidimensional array or not
 */
function is_multi_array($x)
{
    if (count(array_filter($x, 'is_array')) > 0) {
        return true;
    }
    return false;
}

/**
 *  Convert an object to an array.
 *
 *  @param   array   $object  The object to convert
 *  @return  array            The converted array
 */
function object_to_array($object)
{
    if (!is_object($object) && !is_array($object)) {
        return $object;
    }
    return array_map('object_to_array', (array) $object);
}

/**
 *  Check if a value exists in the array/object.
 *
 *  @param   mixed    $needle    The value that you are searching for
 *  @param   mixed    $haystack  The array/object to search
 *  @param   boolean  $strict    Whether to use strict search or not
 *  @return  boolean             Whether the value was found or not
 */
function search_for_value($needle, $haystack, $strict = true)
{
    $haystack = object_to_array($haystack);

    if (is_array($haystack)) {
        if (is_multi_array($haystack)) {   // Multidimensional array
            foreach ($haystack as $subhaystack) {
                if (search_for_value($needle, $subhaystack, $strict)) {
                    return true;
                }
            }
        } elseif (array_keys($haystack) !== range(0, count($haystack) - 1)) {    // Associative array
            foreach ($haystack as $key => $val) {
                if ($needle == $val && !$strict) {
                    return true;
                } elseif ($needle === $val && $strict) {
                    return true;
                }
            }

            return false;
        } else {    // Normal array
            if ($needle == $haystack && !$strict) {
                return true;
            } elseif ($needle === $haystack && $strict) {
                return true;
            }
        }
    }

    return false;
}
