
    <?php

    /* Attempt MySQL server connection. Assuming you are running MySQL

    server with default setting (user 'root' with its password) */

    $con = mysqli_connect("localhost", "root", "@root@");

    // Check connection

    if($con === false){

        die("ERROR: Could not connect. " . mysqli_connect_error());

    }
    // Attempt create database query execution
    $query = 'CREATE Database IF NOT EXISTS test_db';
    $retval = mysqli_query( $con, $query);
    if(! $retval ) 
    {
         die('Could not create database: ' . mysqli_error());

    }
    else {echo "" ;}//"Database test_db created successfully</br>";}
    
    // There can be many databases.
    mysqli_select_db($con, 'test_db');

    // Table : edges is attempting to be created.

    $query = "CREATE TABLE IF NOT EXISTS edges(

    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,

    person1 VARCHAR(30) NOT NULL,

    person2 VARCHAR(30) NOT NULL,

    amount INT NOT NULL 

    )";

    if(mysqli_query($con, $query)){

        echo "";//"Table edges created successfully.</br>";

    } else{

        echo "ERROR: Could not able to execute $query. " . mysqli_error($con);

    }

    // There can be many databases.
    mysqli_select_db($con, 'test_db');

    // Table : simplified_edges is attempting to be created.

    $query = "CREATE TABLE IF NOT EXISTS simplified_edges(

    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,

    person1 VARCHAR(30) NOT NULL,

    person2 VARCHAR(30) NOT NULL,

    amount INT NOT NULL 

    )";

    if(mysqli_query($con, $query)){

        echo "";//"Table simplified_edges created successfully.</br>";

    } else{

        echo "ERROR: Could not able to execute $query. " . mysqli_error($con);

    }

    mysqli_close($con);

	if(isset($_POST['insert_button']))
	{
	    insert();

	}
	elseif (isset($_POST['simplify_button'])) {
		simplify();
	}
	elseif(isset($_POST['delete_simplified_edges'])){
		clear_result();
	}
	elseif (isset($_POST['clear_original_edges'])) {
		clear_original();
	}

    function insert()
    {
    	$con = mysqli_connect("localhost", "root", "@root@");
	    if($con === false){

	        die("ERROR: Could not connect. " . mysqli_connect_error());

	    }
	    // There can be many databases.
        mysqli_select_db($con, 'test_db');

    	 // Fetch data from the webpage and insert into the table
	    if ($_POST["person1"] and $_POST["person2"] and $_POST["amount"])
	    {
	    	$sql = "INSERT INTO edges (person1, person2, amount)
	                  VALUES ("."\"".$_POST["person1"]."\""."," ."\"".$_POST["person2"]."\"".",". $_POST["amount"].")";

	        if ($con->query($sql) === TRUE)
	        {
    			echo "New record created successfully";
    			// Show the table content
    			$result = mysqli_query($con,"SELECT * FROM edges");

				echo "<table border='1'>
				<tr>
				<th>Person1</th>
				<th>Person2</th>
				<th>Amount</th>
				</tr>";

				while($row = mysqli_fetch_array($result))
				{
					echo "<tr>";
					echo "<td>" . $row['person1'] . "</td>";
					echo "<td>" . $row['person2'] . "</td>";
					echo "<td>" . $row['amount'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";

			} 
			else 
			{
    			echo "Error: " . $sql . "<br>" . $con->error;
	   	    }
	   	}
	    else
	 	{
	 		echo "Please fill all the textfields!";
	 	}

	 	// Writing to data_in.txt file
	 	$file = "data_in.txt";
        $f = fopen($file, 'w'); // Open in write mode
        $temp_result = mysqli_query($con,"SELECT * FROM edges");
        while($row = mysqli_fetch_array($temp_result,MYSQLI_ASSOC))
        {
 	        $person1 = $row['person1'];
   		    $person2 = $row['person2'];
   		    $amount = $row['amount'];

            $entry = "$person1 $person2 $amount\n";

           fwrite($f, $entry);
        }

		fclose($f);
		// Free result set
        mysqli_free_result($temp_result);

	 	mysqli_close($con);
	 	//shell_exec("python graph.py");
	    //shell_exec("dot -Tpng input.dot -o input.png");
	 	//echo "Original Transactions <br/><img src= input.png> <br/><br/>";
    }
	
    function simplify()
    {
    	/*
    	$con = mysqli_connect("localhost", "root", "@root@");
	    if($con === false){

	        die("ERROR: Could not connect. " . mysqli_connect_error());

	    }
	    // There can be many databases.
        mysqli_select_db($con, 'test_db');

    	$handle = fopen("data_out.txt", "r");
		if ($handle) 
		{
  			while (($line = fgets($handle)) !== false) 
  			{ // process the line read.
  				$words = explode(" ", $line); // split the string on white spaces
  				//echo $words[0];
  				//echo $words[1];
  				//echo $words[2];
				$sql = "INSERT INTO simplified_edges (person1, person2, amount)
	                  VALUES (".$words[0]."," .$words[1].",". $words[2].")";

	                if(mysqli_query($con, $sql))
	                {

				        echo "";//echo "Insertion in simplified_edges successfull.</br>";

				    } else{

				        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);

				    }
    		}

    		// Show the table content
    		$result = mysqli_query($con,"SELECT * FROM simplified_edges");

			
			
			echo "<table border='1'>
			<tr>
			<th>Person1</th>
			<th>Person2</th>
			<th>Amount</th>
			</tr>";

			while($row = mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>" . $row['person1'] . "</td>";
				echo "<td>" . $row['person2'] . "</td>";
				echo "<td>" . $row['amount'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
			
    		fclose($handle);
		} 
		else 
		{
    		echo "Error opening the data_out.txt file.";
		} 
		mysqli_close($con);
		*/
		//shell_exec("./commands.sh hexa");
	
		echo "<b>Original Transactions</b> <br/><img class=left src= input.png><br/><br/>";
		echo "<b>Simplified Transactions</b> <br/><img class=left src= output.png>";
		
    }

    function clear_result()
    {
    	$con = mysqli_connect("localhost", "root", "@root@");
	    if($con === false){

	        die("ERROR: Could not connect. " . mysqli_connect_error());

	    }
	    // There can be many databases.
        mysqli_select_db($con, 'test_db');
    	mysqli_query($con, "DROP TABLE simplified_edges");
    	mysqli_close($con);
    	// delete the content of the file
	 	$file = "data_out.txt";
        $f = fopen($file, 'w'); // Open in write mode
        fwrite($f, "");
		fclose($f);
    }

    function clear_original()
    {
    	$con = mysqli_connect("localhost", "root", "@root@");
	    if($con === false){

	        die("ERROR: Could not connect. " . mysqli_connect_error());

	    }
	    // There can be many databases.
        mysqli_select_db($con, 'test_db');
    	mysqli_query($con, "DROP TABLE edges");
    	mysqli_close($con);
    	// delete the content of the file
	 	$file = "data_in.txt";
        $f = fopen($file, 'w'); // Open in write mode
        fwrite($f, "");
		fclose($f);
    }

    ?>

<!DOCTYPE html>
<html>
<head>
	<title>SplitUp</title>
</head>
<body>
<form action="<?php $_PHP_SELF?>" method="POST">
	<input type="string" name="person1"> pays <input type="text" name="amount"> rupees to <input type="string" name="person2"><br/>
	<input type="submit" name="insert_button" onclick = "insert()" value="Add new transaction!"> <br/>
	<input type="submit" name="simplify_button" onclick = "simplify()" value="Simplify transactions!"><br/>
	<input type="submit" name="delete_simplified_edges" onclick = "clear_result()" value="Clear Simplified transactions!"><br/>
	<input type="submit" name="clear_original_edges" onclick = "clear_original()" value="Clear Original transactions!">
	
</form>
</body>
</html>

