<?php
include 'handle-queries.php';

$success = true; // Keep track of errors so it redirects the page only if there are no errors
$db_conn = null; // Edit the login credentials in connectToDB()
$show_debug_alert_messages = false; // Set to true if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

function debugAlertMessage($message)
{
    global $show_debug_alert_messages;

    if ($show_debug_alert_messages) {
        echo "<script type='text/javascript'>alert('" . $message . "');</script>";
    }
}

function executePlainSQL($cmdstr)
{
    global $db_conn, $success;

    $statement = OCIParse($db_conn, $cmdstr);

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = false;
    }

    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement);
        echo htmlentities($e['message']);
        $success = false;
    }

    return $statement;
}

function executeBoundSQL($cmdstr, $list)
{
    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr);

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = false;
    }

    foreach ($list as $tuple) {
        foreach ($tuple as $bind => $val) {
            OCIBindByName($statement, $bind, $val);
            unset($val);
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($statement);
            echo htmlentities($e['message']);
            echo "<br>";
            $success = false;
        }
    }
}

function printResult($result, $count, $attribute = [], $name)
{
    echo "<br><tr><td>" . $name . "</td></tr><br>";

    echo "<table>";

    if ($count > 0) {
        echo "<tr>";
        for ($i = 0; $i < $count; $i++) {
            echo "<th>" . $attribute[$i] . "</th>";
        }
        echo "</tr>";
    }

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr>";
        for ($i = 0; $i < $count; $i++) {
            echo "<td>" . $row[$i] . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}

function connectToDB()
{
    global $db_conn;

    // Your username is ora_(CWL_ID) and the password is a(student number). For example,
    // ora_platypus is the username and a12345678 is the password.
    $db_conn = OCILogon("ora_jtesfu", "a72997596", "dbhost.students.cs.ubc.ca:1522/stu");

    if ($db_conn) {
        debugAlertMessage("Database is connected");
        return true;
    } else {
        debugAlertMessage("Cannot connect to the database");
        $e = OCI_Error(); // For OCILogon errors pass no handle
        echo htmlentities($e['message']);
        return false;
    }
}

function disconnectFromDB()
{
    global $db_conn;

    debugAlertMessage("Disconnect from the database");
    OCILogoff($db_conn);
}

// HANDLE ALL POST ROUTES
function handlePOSTRequest()
{
    if (connectToDB()) {
        if (array_key_exists('resetTablesRequest', $_POST)) {
            handleResetRequest();
        } elseif (array_key_exists('insertQueryRequest', $_POST)) {
            handleInsertNewCustomerRequest();
        } elseif (array_key_exists('deleteQueryRequest', $_POST)) {
            handleDeleteCustomerRequest();
        } elseif (array_key_exists('handleUpdateQueryRequest', $_POST)) {
            handleUpdateRequest();
        } elseif (array_key_exists('joinEventQueryRequest', $_POST)) {
            handleEventGivenVenueRequest();
        }

        disconnectFromDB();
    }
}

// HANDLE ALL GET ROUTES
function handleGETRequest()
{
    if (connectToDB()) {
        if (array_key_exists('selectSubmit', $_GET)) {
            handleSelectBookingInfoRequest();
        } elseif (array_key_exists('joinEventTuples', $_GET)) {
            handleEventGivenVenueRequest();
        } elseif (array_key_exists('groupByButton', $_GET)) {
            handleRowsBySectionRequest();
        } elseif (array_key_exists('havingButton', $_GET)) {
            handleRowsWithAvailabilityRequest();
        } elseif (array_key_exists('nestedAggButton', $_GET)) {
            handleExpensiveTicketsByAgeRequest();
        } elseif (array_key_exists('divisionButton', $_GET)) {
            handlePerformersAtEveryEventRequest();
        } elseif (array_key_exists('projectSubmit', $_GET)) {
            handleProjectionOfSeatsRequest();
        }

        disconnectFromDB();
    }
}

if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
    handlePOSTRequest();
} elseif (
    isset($_GET['countTuples']) || isset($_GET['selectSubmit']) || isset($_GET['projectSubmit']) ||
    isset($_GET['joinEventTuples']) || isset($_GET['groupByButton']) || isset($_GET['havingButton']) ||
    isset($_GET['nestedAggButton']) || isset($_GET['divisionButton'])
) {
    handleGETRequest();
}
?>
