<?php
/*
                       Author Ahmed Shabbir
                       CLASS PL Tuesday
                       exit codes (just in case if we want to use it as an autmations script)
                               0 = success
                               1 = input file error
                               2 = output file error
                               3 = Cypher error
                               4 = parameters
*/



				//Checks for Command Line params 
				//argv[1] is task type 
               if(! isset($argv[1]) )
               {
                       echo "ERR: Kindly specify TASK (1 or 2).. \n";
                       echo "ERR: Kindly specify Input file.. \n";
                       echo "ERR: Kindly specify output file..\n";
                       exit(4);
               }
				//argv[1] should be either 1 or 2 any thing else results in user error message
               if($argv[1] != "1" and $argv[1]!= "2")
               {
                    echo "Err: invalid Task. \n\n";
               		exit(4);
               }


				//argv[2] is input file 
               if(! isset($argv[2]) )
               {
                       echo "ERR: Kindly specify Input file.. \n";
                       echo "ERR: Kindly specify output file..\n";
                       exit(4);
               }

				//argv[3] is output file
               if(! isset($argv[3]) )
               {
                       echo "ERR: Kindly specify output file..\n";
                       exit(4);
               }

				//all command line params are good proceed with processing
               $inputFileName = $argv[2];
               $outputFileName = $argv[3];
               $taskType = $argv[1];

               //get current directory. Set input and output paths - to make sure it is platform independent
               $directory = getcwd();
               $input = $directory . "/" .$inputFileName ;
               $output = $directory . "/"   .$outputFileName ;

               //check if input file exist. if it does then proceed
               if (! file_exists($input))
               {
                    echo "ERR: The file $input does not exists.. exiting program with error Code.... \n  \n";
                    exit(1);
               }


               //check if out file exist. if it doest then delete
               if (file_exists($output))
               {
					//use unlink to delete the output file if its already present
                  		unlink($output);
                       if ( file_exists($output))
                       {
								//file was not deleted ask the user to manually delete the file
                               echo "ERR: file $output could not be deleted. Kindly close all references and manually delete the file..\n\n";
                               exit(2);
                       }
               }



				//read the file into a variable
			       $line = file_get_contents($input);

			       //split the file read into an array of char
			       $arrSplit =  str_split($line);

			       //loop through the array
			       //cypher the char and append it to a new variable 
			       $cypherLine = "";

               //do the task 
               if($taskType == 1)
               {
			       foreach($arrSplit as $value)
			       {
			               $cypherLine = $cypherLine  . charChanger($value);
			       }
               }
               elseif($taskType == 2)
               {
               	 foreach($arrSplit as $value)
			       {
			               $cypherLine = $cypherLine  . CaesarCypher($value);
			       }
               }
			 
				file_put_contents($output, $cypherLine);

		       if (! file_exists($output))
		       {
		               echo "ERR: file $output was not saved..\n \n";
		               exit(2);
		       }
		       exit(0);






/*Function 
we will receive each Character in this function
and will return a cypher value Without using array
<<Parameter : char : single char to be converted >>
*/
function charChanger( $chr )
{
       $modChr = "";
       $asciCode =     ord($chr);
       if($asciCode > 64 && $asciCode < 91)
       {
               //ASCI switch (13 +) for  ABC..Z
               $asciCode = $asciCode + 13;
               if($asciCode > 90)
               {
                       $asciCode = $asciCode - 91 + 65;
               }
               $modChr = chr($asciCode);
               return $modChr;
       } elseif($asciCode > 96 && $asciCode < 123)
       {
               //ASCI switch (13 +) for abc..z
               $asciCode = $asciCode + 13;
               if($asciCode > 122)
               {
                       $asciCode = $asciCode - 123 + 97;
               }
                       $modChr = chr($asciCode);
               return $modChr;
       }
       elseif ($asciCode > 47 && $asciCode < 58)
       {
            //ASCI switch (5 +) for 0123..9
               $asciCode = $asciCode + 5;
               if($asciCode > 57)
               {
                       $asciCode = $asciCode - 58 + 48;
               }
               $modChr = chr($asciCode);
               return $modChr;

       }
	//return original char if this code block is reached
       return $chr;
}





/*Function 
we will receive each Char in this function
and will return a cypher value
<<Parameter : char : single char to be converted >>
*/

function CaesarCypher( $CharParam )
{
       //Create your associative array 
       $arrMaping = array(
			'a' => 'q' , 
			'e' => 'w' , 
			'i' => 'g' , 
			'o' => 'r' , 
			'u' => 't' , 
			'A' => 'Q' , 
			'E' => 'W' , 
			'I' => 'G' , 
			'O' => 'R' , 
			'U' => 'T' , 
			's' => 'z' , 
			'S' => 'Z' , 
			'd' => 'c' , 
			'D' => 'C' );


       //check if parameter char exist in array keys
       if (array_key_exists( $CharParam, $arrMaping))
       {
               //if true then return value
               return $arrMaping[$CharParam];
       }
       // if reached return param Char (is an special case non alpha numeric)
       return $CharParam;

}


?>