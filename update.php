  


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
 
<style>
    h1{
        font-family: fantasy;
        color: blue
    }
    input::placeholder{
        color: lightsteelblue
    }
    
    #qty{
        width: 50px
    }
    
    #ere{
        text-align: center;
        font-size: 50px; 
        color: red;
    }
    
    #eri{
        font-size: 20px;  
        margin-left: 400px;
        font-family: sans-serif;
    }
    
    #erf{
        font-size: 20px;  
        margin-left: 500px;
        font-family: sans-serif;
    }
    
    label{
        font-size: 20px;
        margin-left: 10px;
    }
    
    #irs{
        font-size: 20px;
        margin-left: 100px;
        font-family: sans-serif;
    }
    
    #suc{
        text-align: center;
        font-size: 50px; 
        color: green;
    }
    #erj{
        text-align: center;
        font-size: 30px; 
        color: red;
    }
    </style>    
    
<center><h1> Add items into an existing Purchase </h1></center>    
</head>


    
    
<?php
    
        $conn = mysqli_connect('localhost','root','','modibuy');
        if (!$conn) 
            {
                die("Connection failed: ". mysqli_connect_error());
            }
?>      

    

    
<body>
    <form action='' id="myform" method="post">
        
        <label> Purchase Number please: </label>
        <input type="number" min="1" name="Purchase-number" id="ordnum"; placeholder="Only digits please">
        <br><br><br>
        
        <label> Product Number please: </label>
        <input type="number" min="1" name="Product-number" id="p-num"; placeholder="Only digits please">
        <?php echo str_repeat("&nbsp",5); ?>
        
        <label> Quantity please: </label>
        <input type="number" min="1" name="Amount" id="qty";>
        
        <br><br><br>
        <label> Supplier Number please: </label>
        <input type="number" min="1" name="Supplier-number" id="s-num"; placeholder="Only digits please">
        
    
    <br><br><br>
    
    <?php echo str_repeat("&nbsp",30); ?>
    
    <input type="submit" name="submit" value="Add product to Purchase">
    
    </form>
    

    
    

    <?php
    $a = ["Purchase-number",'Product-number',"Amount","Supplier-number"];
    
    $missing=[];
    
    if (isset($_POST['submit']))
    {
        
        
        foreach($a as $val)
            {

                if (isset($_POST[$val]) == 0 or empty($_POST[$val]))
                {
                    array_push($missing,str_replace("-"," ",$val));
                }


            }
        
        
        if (count($missing)>0)
            {
                $t=1;
                echo "<p id=ere> you left those fields empty:</p>";
                foreach($missing as $val){
                    
                    echo "<p id=eri> $t. $val <br></p>"; $t++;
                }
            }
        
        else
            
            
        {   
            $pur = $_POST['Purchase-number'];
            $pr = $_POST['Product-number'];
            $qty = $_POST["Amount"];
            $sup = $_POST["Supplier-number"];
            
            $mis=[];
            $s_purch = "select PurchaseNum from purchase where Purchasenum = $pur ;";
            $sql = "select ProductNum,SupplierNum from sells where SupplierNum = $sup and ProductNum = $pr;";
            $result = mysqli_query($conn,$s_purch);
            $result1 = mysqli_query($conn,$sql);
            
            
            $purshalt =0;
            $supshalt = 0;
            if (empty(mysqli_fetch_array($result))){
                $purshalt++;
                #echo "<p id=erf>1. There isnt any ". $mis[0]." '$pur' on database</p>";
            }
            
            if (empty(mysqli_fetch_array($result1))){
                $supshalt++;
            }
            
            if ($purshalt == 1 or $supshalt == 1){
                echo "<p id=ere> The Mistakes Are</p>";
                if ($purshalt == 1)
                {echo "<p id=irs>&bull; '$pur' is not a valid Purchase Number.<br>  ";}
                if($supshalt == 1){echo "<p id=irs>&bull; We didnt find in the system product number: ''$pr'' which been sold   by a supplier with the <br> &nbsp supplier number: ''$sup''.<br> &nbsp Please insert a valid combination of product and supplier number!   ";}
                
            }
            
            else{
                
                $s1 = "select PurchaseNum from purchasecontains where SupplierNum = $sup and ProductNum = $pr and PurchaseNum = $pur;";
                $result  = mysqli_query($conn,$s1);
                $success = 0;
                if (!empty(mysqli_fetch_array($result)))
                    {
                        echo "<p id=erj>Product number: $pr from Supplier number: $sup <br> already exists in purchase number: $pur. <br> please select some other products or the same product from another supplier<br> if exists.</p>";
                        #$s1  = "UPDATE purchasecontains set `Amount`= `Amount`+ $qty where `ProductNum` = $pr AND
                               # `SupplierNum` = $sup
                               # AND `PurchaseNum` = $pur;";
                        #$result  = mysqli_query($conn,$s1);

                        #if($result == true){$success = 1;}

                    }
                
                
                else{
                        $s1 = "insert into purchasecontains values($pur,$sup,$pr,$qty);";
                        $result  = mysqli_query($conn,$s1);
                        if($result == true){$success = 1;}
                    }
                
                if($success == 1){
                    echo "<p id=suc>Order Number: $pur Updated Successfully! </p>";
                }
                
                }
            
            
            
            
        }
        
        
        
        
        
        
    }
    
    
    
    
    
    ?>
    
    
    
    
    
    
</body>
</html>
