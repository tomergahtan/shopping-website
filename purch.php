<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ModiBuy</title>
    <center><h1>Create New Purchase</h1></center>
    
    
</head> 
    
<style>
    select{
        width: 80px;
        text-align: center;
    }
    
    #qty{
        width: 50px;
    }
    
    
    #bot{
        padding: 10px 30px;
        
    }
    
    #ere{
        font-size: 30px;
        color:red;
    }
    #ere1{
        font-size: 30px;
        color:green
    }
    
    label{
        font-size: 20px;
        font-family: sans-serif;
        }
    h1{
        font-family: fantasy;
        font-size: 55px
    }
</style>
   

    

<?php
    
        $conn = mysqli_connect('localhost','root','','modibuy');
        if (!$conn) 
            {
                die("Connection failed: ". mysqli_connect_error());
            }
?>    

    
<script>
var products={}; 
</script>

    
      <?php
    
            $sql="select ProductNum from product";
            $result = mysqli_query($conn,$sql) ;
        while($row = mysqli_fetch_array($result)){
            echo "<script>";
            echo "products[$row[0]] = []";
            
            echo "</script>";
        }
    
    
    
            $sql="select ProductNum,SupplierNum from sells";
            $result = mysqli_query($conn,$sql) ;
            
            while($row = mysqli_fetch_array($result)){
                echo "<script>";
                echo "products[$row[0]].push($row[1]) ";
                echo "</script>";
            }
        ?>     

    

    
<script>
   
var pr = document.getElementById("prodnum");
var sp = document.getElementById("supid");

window.onload = function(){
   var pr = document.getElementById("prodnum");
    var sp = document.getElementById("supid"); 
    for (var x in products)
        {
        
        pr.options[pr.options.length] = new Option(x,x);
        }
    
    pr.onchange = function(){
        sp.length = 1;
        for (var y in products[this.value]) {
            
            sp.options[sp.options.length] = new Option(products[this.value][y], products[this.value][y]);
    }
        }
    }
    
 </script>   
    
    
    
    
        
 
 <body>
     
     <form action='' id="myform" method="post">
     <div>
         <div>
             <label>Customer Number please: </label>
             <select name="customer-number" id="customerlist" class="inputbox">
                 <option value disabled selected>---select---</option>
             
             
            <?php
                 
                $sql="select CustomerNum from customer";
                $result = mysqli_query($conn,$sql) ;
                while ($row = mysqli_fetch_array($result)){
                    echo "<option value=$row[0]>$row[0]</option>"; 
                } 
            ?>     
             </select>
             
         </div>
         
         <br><br>
         
        <div>
             <label>Shipping company number please: </label>
             <select name="shipping-company-number" id="shippingnum-list" class="inputbox" >
                <option value disabled selected>---select---</option> 
                 
             
             
                 
            <?php
                 
                $sql = "select shippingcompanynum from shippingcompany";
                $result = mysqli_query($conn,$sql) ;
                while ($row = mysqli_fetch_array($result)){
                    echo "<option value=$row[0]>$row[0]</option>"; 
                } 
                 
                 
            ?>     
             
             </select>
             
         
         
         </div>
         
        <br><br> 
            
         
         
        
             <label>Product number please: </label>
        <select name="product-number"; id="prodnum" ;>
             <option value disabled selected>---select---</option>
             </select> 
         

         
            <?php echo str_repeat("&nbsp",5); ?>
            
            <label>Supplier number please: </label>
            <select name="supplier-number" id="supid" class="inputbox">
             <option value disabled selected>---Select---</option>
                
             </select> 
         <?php echo str_repeat("&nbsp",5); ?>
         
         <label> Quantity: </label>
         <input type="number" min="1" name="Quantity" id="qty" value''>
         
    </div>
     
     <br>
     <input type="submit" name="subit" value="Create New Order" id = bot>
     </form>
    
     
     
     
     
     
     
     
     
     
     
     
     
     
    <?php
     
     $a= ['customer-number',"shipping-company-number","product-number",'supplier-number','Quantity'];
     $missing = [];

    
    if(isset($_POST['subit'])){ 
        
        
        foreach($a as $val)
            {

                if (isset($_POST[$val]) == 0 or empty($_POST[$val])){
                    array_push($missing,$val);
                }


            }


        if (count($missing)>0)
        {
            echo"<center>";  
            echo "<p id='ere'>" . "You forgot to add proper values on the following fields:</p> ";
            echo"</center>";
            $ind = 1;

            foreach($missing as $val){
                echo str_repeat("&nbsp",90).$ind.". ".ucwords(str_replace('-'," ",$val)).'<br>'; $ind+=1;
                                    }

            
             
        }

         else{
             $sql = "SELECT MAX(`PurchaseNum`) from purchase;";
             $result = mysqli_query($conn,$sql) ;
             
             $c_num = $_POST['customer-number'];
             $sc_num = $_POST["shipping-company-number"];
             $sup_num = $_POST['supplier-number'];
             $prod_num = $_POST['product-number'];
             $qty = $_POST ['Quantity'];
             
             $ord = mysqli_fetch_array($result)[0]+1;
             
             
             $sql_insert_p = "insert into purchase values($ord,now(),$c_num,$sc_num)";
             $r1 = mysqli_query($conn,$sql_insert_p);
            if (!$r1) 
            {
                die("failed with connection to purchases table! ". mysqli_connect_error());
            }
             
             $sql_insert_pc="insert into purchasecontains values($ord,$sup_num,$prod_num,$qty)";
             
             $r2 = mysqli_query($conn,$sql_insert_pc);
             
            if (!$r2) 
            {
                die("failed with connection to purchasecontains table! ". mysqli_connect_error());
            }
             
             echo"<center>";  
             echo "<p id='ere1'>" . "Order $ord Successfully Submitted!<br></p> ";
             echo"</center>";
             
             
              
             
             
         }
        
    
    }
 
     
     ?>
    
    
    
    
    
    
    
    
    
    
    
</body>
  

</html>