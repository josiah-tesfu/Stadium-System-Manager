<?php
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

    ?>