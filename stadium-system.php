<html>

<head>
    <title>Stadium Management System</title>
</head>

<body>

    <hr />

    <h2>Insert Values into Booking System</h2>
    <form method="POST" action="stadium-system.php">
        <!--INSERT Operation; implementation: handleInsertNewCustomerRequest(), line 310-->
        <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
        Customer name: <input type="text" name="customer-name"> <br /><br />
        Email: <input type="text" name="email"> <br /><br />
        Customer ID: <input type="text" name="customer-id"> <br /><br />
        Password: <input type="text" name="password"> <br /><br />

        <input type="submit" value="Insert" name="insertSubmit"></p>
    </form>

    <hr />

    <h2>Update Name into Booking System</h2>
    <p>Choose any of the following values to update. The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

    <form method="POST" action="stadium-system.php">
        <!--UPDATE Operation; implementation: handleUpdateRequest(), line 276-->
        <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
        Customer name: <input type="checkbox" name="update-name"> <br /><br />
        Old name: <input type="text" name="old-name"> New Name: <input type="text" name="new-name"> <br /><br />

        Email: <input type="checkbox" name="update-email"> <br /><br />
        Old email: <input type="text" name="old-email"> New email: <input type="text" name="new-email"> <br /><br />

        Customer ID: <input type="checkbox" name="update-id"> <br /><br />
        Old ID: <input type="text" name="old-id"> New customer ID: <input type="text" name="new-id"> <br /><br />

        Password: <input type="checkbox" name="update-password"> <br /><br />
        Old password: <input type="text" name="old-password"> New password: <input type="text" name="new-password"> <br /><br />

        <input type="submit" value="Update" name="updateSubmit"></p>
    </form>

    <hr />


    <h2>Delete Tuples in Booking System</h2>
    <form method="POST" action="stadium-system.php">
        <!--DELETE Operation; implementation: handleDeleteCustomerRequest(), line: 324-->
        <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
        Delete customer with ID: <input type="text" name="deleteId"> <br /><br />

        <input type="submit" value="Delete" name="deleteSubmit"></p>
    </form>

    <hr />

    <h2>Select Tuples in Booking System Based on Table, Attributes, and Conditions </h2>
    <form method="GET" action="stadium-system.php">
        <!--Selection Operation; implementation: handleSelectBookingInfoRequest(), line: 343-->
        <input type="hidden" id="selectQueryRequest" name="selectQueryRequest">
        CUSTOMER<input type="radio" name="table-selection" id="select-customer" value="customer"> <br /><br />
        EVENT<input type="radio" name="table-selection" id="select-event" value="event"> <br /><br />
        VENUE<input type="radio" name="table-selection" id="select-venue" value="venue"> <br /><br />

        Customer options: #1: name, #2: password <br /><br />
        Venue options: #1: name, #2: address <br /><br />
        Event options: #1: name, #2: date <br /><br />

        Option #1 <input type="checkbox" name="option-1">
        <input type="text" name="condition-1"> <br /><br />
        Option #2 <input type="checkbox" name="option-2">
        <input type="text" name="condition-2"> <br /><br />

        <input type="submit" value="Select" name="selectSubmit"></p>
    </form>


    <h2>Display Projection of Seats</h2>
    <p>Based on at least one of seat section, row, and availability
    <p>
    <form method="GET" action="stadium-system.php"></form>
    <!--Projection Operation; implementation: handleProjectionOfSeatsRequest(), line 402-->
    <input type="checkbox" name="seat-type" value="section">Seat_Section
    <input type="checkbox" name="seat-type" value="row">Seat_Row
    <input type="checkbox" name="seat-type" value="availability">Seat_Availability

    <input type="hidden" id="projectSeatsQueryRequest" name="projectSeatsQueryRequest">
    <input type="submit" value="Show Seats" name="projectSubmit"></p>
    </form>

    <hr />

    <h2>Find Event Name and Date Given a Venue</h2>
    <form method="GET" action="stadium-system.php">
        <!--Join Operation; implementation: handleEventGivenVenueRequest(), line 443-->
        <input type="hidden" id="joinEventQueryRequest" name="joinEventQueryRequest">
        Venue Name: <input type="text" name="venueName"> <br /><br />

        <input type="submit" value="Find Events" name="joinEventTuples">
    </form>

    <hr />

    <h2>Find the number of Seat Rows in Each Section</h2>
    <!--Aggregation with Group By Operation; implementation: handleRowsBySectionRequest(), line 455-->
    <form method="GET" action="stadium-system.php">
        <input type="hidden" id="aggGroupByRequest" name="groupByRequest">
        <input type="submit" name="groupByButton">
    </form>

    <hr />

    <h2>Find all Seat Sections that Have at least 5 Available Seats</h2>
    <p>Lower row numbers are closer to the stage. A row less than 4 is considered 'good'</p>
    <!--Aggregation with Having Operation; implementation: handleRowsWithAvailabilityRequest(), line 467-->
    <form method="GET" action="stadium-system.php">
        <input type="hidden" id="aggHavingRequest" name="aggHavingRequest">
        <input type="submit" name="havingButton">
    </form>

    <hr />

    <h2>Find the Total Number of Tickets Sold over $200 Within Each Age Group</h2>
    <!--Nested Aggregation with Group By Operation; implementation: handleExpensiveTicketsByAgeRequest(), line 482-->
    <form method="GET" action="stadium-system.php">
        <input type="hidden" id="nestedAggRequest" name="nestedAggRequest">
        <input type="submit" name="nestedAggButton">
    </form>

    <hr />

    <h2>Find the Performers that have Performed at Every Event</h2>
    <!--Division Operation; implementation: handlePerformersAtEveryEventRequest(), line 499-->
    <form method="GET" action="stadium-system.php">
        <input type="hidden" id="divisionRequest" name="divisionAggRequest">
        <input type="submit" name="divisionButton">
    </form>

    <hr />


    <?php
    //this tells the system that it's no longer just parsing html; it's now parsing PHP

    $success = True; //keep track of errors so it redirects the page only if there are no errors
    $db_conn = NULL; // edit the login credentials in connectToDB()
    $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

    function debugAlertMessage($message)
    {
        global $show_debug_alert_messages;

        if ($show_debug_alert_messages) {
            echo "<script type='text/javascript'>alert('" . $message . "');</script>";
        }
    }

    function executePlainSQL($cmdstr)
    { //takes a plain (no bound variables) SQL command and executes it
        //echo "<br>running ".$cmdstr."<br>";
        global $db_conn, $success;

        $statement = OCIParse($db_conn, $cmdstr);
        //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
            echo htmlentities($e['message']);
            $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            $success = False;
        }

        return $statement;
    }

    function executeBoundSQL($cmdstr, $list)
    {
        /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

        global $db_conn, $success;
        $statement = OCIParse($db_conn, $cmdstr);

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }

        foreach ($list as $tuple) {
            foreach ($tuple as $bind => $val) {
                //echo $val;
                //echo "<br>".$bind."<br>";
                OCIBindByName($statement, $bind, $val);
                unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                echo htmlentities($e['message']);
                echo "<br>";
                $success = False;
            }
        }
    }

    function printResult($result, $count, $attribute = [], $name)
    { //prints results from a select statement
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
            debugAlertMessage("Database is Connected");
            return true;
        } else {
            debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }

    function disconnectFromDB()
    {
        global $db_conn;

        debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }

    // Update Operation
    function handleUpdateRequest()
    {
        global $db_conn;

        $new_name = $_POST['new-name'];
        $new_password = $_POST['new-password'];
        $new_email = $_POST['new-email'];
        $new_id = $_POST['new-id'];

        $old_name = $_POST['old-name'];
        $old_password = $_POST['old-password'];
        $old_email = $_POST['old-email'];
        $old_id = $_POST['old-id'];

        if (isset($_POST['update-name'])) {
            executePlainSQL("UPDATE Customer SET customer_name='" . $new_name . "' WHERE customer_name='" . $old_name . "'");
        }
        if (isset($_POST['update-id'])) {
            executePlainSQL("UPDATE Customer SET customer_id='" . $new_password . "' WHERE customer_id='" . $old_id . "'");
        }
        if (isset($_POST['update-email'])) {
            executePlainSQL("UPDATE Customer SET customer_email='" . $new_email . "' WHERE customer_email='" . $old_email . "'");
        }
        if (isset($_POST['update-password'])) {
            executePlainSQL("UPDATE Customer SET customer_password='" . $new_id . "' WHERE customer_password='" . $old_password . "'");
        }

        $result = executePlainSQL("SELECT * FROM customer s");
        printResult($result, 4, array("CUSTOMER_NAME, EMAIL, CUSTOMER_ID, PASSWORD"), "UPDATED CUSTOMERS:");

        OCICommit($db_conn);
    }

    // Insert Query
    function handleInsertNewCustomerRequest()
    {
        global $db_conn;

        $customer_name = $_POST['customer-name'];
        $customer_id = $_POST['customer-id'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        executePlainSQL("INSERT INTO customer (customer_name, email, customer_id, customer_password) VALUES($customer_name, $email, $customer_id, $password)");
        OCICommit($db_conn);
    }

    // Delete Query
    function handleDeleteCustomerRequest()
    {
        global $db_conn;

        $delete_id = $_POST['deleteID'];

        $result = executePlainSQL("SELECT * FROM customer c WHERE c.customer_id = $delete_id");
        printResult($result, 4, array("CUSTOMER_NAME, EMAIL, CUSTOMER_ID, PASSWORD"), "CUSTOMER: ");

        executePlainSQL("DELETE FROM Customer c WHERE c.customer_id = $delete_id");
        OCICommit($db_conn);

        // handleDisplayRequest();


    }

    // Selection Query
    function handleSelectBookingInfoRequest()
    {
        global $db_conn;

        $table_selection = $_POST['table-selection'];


        $option_1 = $_GET['option-1'];
        $option_2 = $_GET['option-2'];
        $result = '';

        // select based off both attributes
        if ((isset($_GET['option-1'])) and (!(isset($_GET['option-2'])))) {

            if ($table_selection == 'customer') {
                $result = executePlainSQL("SELECT '" . $option_1 . "' , '" . $option_2 . "' FROM $table_selection WHERE  '" . $option_1 . "' AND '" . $option_2 . "' ");
                printResult($result, 2, array($option_1, $option_2), "CUSTOMER:");
            } else if ($table_selection == 'venue') {
                $result = executePlainSQL("SELECT '" . $option_1 . "' , '" . $option_2 . "' FROM $table_selection WHERE  '" . $option_1 . "' AND '" . $option_2 . "' ");
                printResult($result, 2, array($option_1, $option_2), "VENUE:");
            } else if ($table_selection == 'event') {
                $result = executePlainSQL("SELECT '" . $option_1 . "' , '" . $option_2 . "' FROM $table_selection WHERE  '" . $option_1 . "' AND '" . $option_2 . "' ");
                printResult($result, 2, array($option_1, $option_2), "EVENT:");
            }
            OCICommit($db_conn);

            // select based off first attribute
        } else if ((isset($_GET['option-1'])) and (!(isset($_GET['option-2'])))) {

            if ($table_selection == 'venue') {
                $result = executePlainSQL("SELECT '" . $option_1 . "' FROM $table_selection WHERE  '" . $option_1 . "' ");
                printResult($result, 1, array($option_1), "CUSTOMER:");
            } else if ($table_selection == 'venue') {
                $result = executePlainSQL("SELECT '" . $option_1 . "' FROM $table_selection WHERE  '" . $option_1 . "' ");
                printResult($result, 1, array($option_1), "VENUE:");
            } else if ($table_selection == 'event') {
                $result = executePlainSQL("SELECT '" . $option_1 . "' FROM $table_selection WHERE  '" . $option_1 . "' ");
                printResult($result, 1, array($option_1), "EVENT:");
            }
            OCICommit($db_conn);

            // select based off second attribute
        } else if ((isset($_GET['option-2'])) and (!(isset($_GET['option-1'])))) {

            if ($table_selection == 'event') {
                $result = executePlainSQL("SELECT '" . $option_2 . "' FROM $table_selection WHERE  '" . $option_2 . "' ");
                printResult($result, 1, array($option_2), "CUSTOMER:");
            } else if ($table_selection == 'venue') {
                $result = executePlainSQL("SELECT '" . $option_2 . "' FROM $table_selection WHERE  '" . $option_2 . "' ");
                printResult($result, 1, array($option_2), "VENUE:");
            } else if ($table_selection == 'event') {
                $result = executePlainSQL("SELECT '" . $option_2 . "' FROM $table_selection WHERE  '" . $option_2 . "' ");
                printResult($result, 1, array($option_2), "EVENT:");
            }
            OCICommit($db_conn);
        }
    }

    // Projection Query
    function handleProjectionOfSeatsRequest()
    {

        global $db_conn;

        $section_proj = $_GET['section'];
        $row_proj = $_GET['row'];
        $avail_proj = $_GET['avail'];

        // first set
        if ((isset($section_proj)) and (!isset($row_proj)) and (!isset($avail_proj))) {
            $result = executePlainSQL("SELECT '" . $section_proj . "' FROM Seat ");
            printResult($result, 1, array("SEAT_SECTION"), "SEAT:");
            // second set
        } else if ((!isset($section_proj)) and (isset($row_proj)) and (!isset($avail_proj))) {
            $result = executePlainSQL("SELECT '" . $row_proj . "' FROM Seat ");
            printResult($result, 1, array("SEAT_ROW"), "SEAT:");
            // third set
        } else if ((!isset($section_proj)) and (!isset($row_proj)) and (isset($avail_proj))) {
            $result = executePlainSQL("SELECT '" . $avail_proj . "' FROM Seat ");
            printResult($result, 1, array("SEAT_AVAILABILITY"), "SEAT:");
            // first and second
        } else if ((isset($section_proj)) and (isset($row_proj)) and (!isset($avail_proj))) {
            $result = executePlainSQL("SELECT '" . $section_proj . "' , '" . $row_proj . "' FROM Seat ");
            printResult($result, 1, array("SEAT_SECTION", "SEAT_ROW"), "SEAT:");
            // first and third
        } else if ((isset($section_proj)) and (isset($row_proj)) and (!isset($avail_proj))) {
            $result = executePlainSQL("SELECT '" . $section_proj . "' , '" . $avail_proj . "' FROM Seat ");
            printResult($result, 1, array("SEAT_SECTION", "SEAT_AVAILABILITY"), "SEAT:");
            // second and third
        } else if ((!isset($section_proj)) and (isset($row_proj)) and (isset($avail_proj))) {
            $result = executePlainSQL("SELECT '" . $row_proj . "' , '" . $avail_proj . "' FROM Seat ");
            printResult($result, 1, array("SEAT_ROW", "SEAT_AVAILABILITY"), "SEAT:");
            // all set
        } else if ((isset($section_proj)) and (isset($row_proj)) and (isset($avail_proj))) {
            $result = executePlainSQL("SELECT '" . $section_proj . "' , '" . $row_proj . "' , '" . $avail_proj . "' FROM Seat ");
            printResult($result, 1, array("SEAT_SECTION", "SEAT_ROW", "SEAT_AVAILABILITY"), "SEAT:");
        }
    }

    // Join Query
    function handleEventGivenVenueRequest()
    {

        global $db_conn;

        $result = executePlainSQL("SELECT v.event_name, v.event_date
            FROM venue v, stadium_event e
            WHERE v.event_name = e.event_name AND v.event_date = e.event_date");

        printResult($result, 2, array("EVENT_NAME", "EVENT_DATE"), "EVENT GIVEN VENUE");
    }

    // Aggregation with Group By Query
    function handleRowsBySectionRequest()
    {

        global $db_conn;

        $result = executePlainSQL("SELECT Count(seat_row), seat_section FROM seat GROUP BY seat_section");

        printResult($result, 2, array("NUMBER OF SEAT ROWS", "SEAT_SECTION"), "SEAT ROWS IN EACH SECTION");
    }

    // Aggregation with Having Query
    function handleRowsWithAvailabilityRequest()
    {

        global $db_conn;

        $result = executePlainSQL("SELECT seat_section, Count(seat_section)
            FROM seat
            WHERE seat_avail == 'Yes'
            GROUP BY seat_section
            HAVING  Count(*) > 5");

        printResult($result, 2, array("SEAT_SECTION", "NUMBER OF SEATS"), "SECTIONS WITH AT LEAST 5 AVAILABLE SEATS");
    }

    // Nested Aggregation with Group By Query
    function handleExpensiveTicketsByAgeRequest()
    {

        global $db_conn;

        $result = executePlainSQL("SELECT t.age_group, COUNT(*)
            FROM ticket t, purchase p
            WHERE t.purchase_id = p.purchase_id
            GROUP BY t.age_group
            HAVING COUNT(*) (SELECT purchase p
                             FROM purchase p
                             WHERE p.price > 200)");

        printResult($result, 2, array("AGE GROUP", "NUMBER OF TICKETS"), "TICKETS SOLD OVER $200 IN EACH AGE GROUP");
    }


    // Division Query
    function handlePerformersAtEveryEventRequest()
    {

        global $db_conn;

        $result = executePlainSQL("SELECT p.performer_name 
            FROM performer p
            WHERE NOT EXISTS ((SELECT e.event_name
                                FROM stadium_event e)
                                EXCEPT
                                (SELECT s.performer_name
                                FROM perform_at s
                                WHERE s.performer_name = p.performer_name))");

        printResult($result, 1, array("PERFORMER NAME"), "PERFORMERS THAT PERFORMED AT EVERY EVENT");
    }




    // HANDLE ALL POST ROUTES
    function handlePOSTRequest()
    {
        if (connectToDB()) {
            if (array_key_exists('resetTablesRequest', $_POST)) {
                handleResetRequest();
            } else if (array_key_exists('insertQueryRequest', $_POST)) {
                handleInsertNewCustomerRequest();
            } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                handleDeleteCustomerRequest();
            } else if (array_key_exists('handleUpdateQueryRequest', $_POST)) {
                handleUpdateRequest();
            } else if (array_key_exists('joinEventQueryRequest', $_POST)) {
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
            } else if (array_key_exists('joinEventTuples', $_GET)) {
                handleEventGivenVenueRequest();
            } else if (array_key_exists('groupByButton', $_GET)) {
                handleRowsBySectionRequest();
            } else if (array_key_exists('havingButton', $_GET)) {
                handleRowsWithAvailabilityRequest();
            } else if (array_key_exists('nestedAggButton', $_GET)) {
                handleExpensiveTicketsByAgeRequest();
            } else if (array_key_exists('divisionButton', $_GET)) {
                handlePerformersAtEveryEventRequest();
            } else if (array_key_exists('projectSubmit', $_GET)) {
                handleProjectionOfSeatsRequest();
            }

            disconnectFromDB();
        }
    }

    if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
        handlePOSTRequest();
    } else if (
        isset($_GET['countTuples']) || isset($_GET['selectSubmit']) || isset($_GET['projectSubmit']) ||
        isset($_GET['joinEventTuples']) || isset($_GET['groupByButton']) || isset($_GET['havingButton']) ||
        isset($_GET['nestedAggButton']) || isset($_GET['divisionButton'])
    ) {
        handleGETRequest();
    }
    ?>
</body>

</html>