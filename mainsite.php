<!DOCTYPE html>
<html lang="en">
    
    
   
    
<head>
    <meta charset="UTF-8">

<center>
    <h1>ModiBuy</h1>
    </center> 
    
    
</head>    


    
<body>
    <center>

        <style>
        table, th, td
            {
                border: 1px solid black;
                text-align: center;
                border-radius: 20px;
            }
            
            tr
            {
                font-family: cursive;
                font-size: 16px;
            }
            
            th
            {
                font-family: cursive;
                font-size: 19px;
            }
            
        #pit{
            font-size: 22px;
            font-weight: bold;
            font-family: cursive
        }
        tr:nth-child(even) {background-color: lightgray;}    
        </style>
        
        

    
    <div> 
 <img src="hello.jpg" hight = "2000" width="600"  alt="myPic" /> 
    </div>
    
        
    <p id=pit>
        
        welcome to "ModiBuy" Shopping site.<br> "ModiBuy" is an e-commerce website,<br>which intended to impove the online purchase experience for the citizens of india. <br>We are Wishing to you a Wonderful shopping experience. 
    </p>    
        
    <?php 
    


    $conn = mysqli_connect('localhost','root','','modibuy');
    if (!$conn) {
            die("Connection failed: ". mysqli_connect_error());
                }

    

        
        
        
    
    echo "<br>";
    
    $sql = "SELECT 
p.PurchaseNum,
p.`PurchaseTime`,
c.`CustomerNum`,
c.`CustomerName`,

a.Num_Of_Different_Items,
SUM(`Amount`*`UnitPrice`) as Total_Amount,
sc.`ShippingCompanyNum`

FROM 
customer c,
purchase p,
purchasecontains pc,
shippingcompany sc,
sells s,
(SELECT pc.`PurchaseNum`,count(*) as Num_Of_Different_Items FROM purchasecontains pc
GROUP BY(`PurchaseNum`)) a

WHERE pc.`PurchaseNum` = p.`PurchaseNum`
and p.`PurchaseNum` = a.`PurchaseNum`
and c.`CustomerNum` = p.`CustomerNum`
AND sc.`ShippingCompanyNum` = p.`ShippingCompanyNum`
and s.`SupplierNum` = pc.`SupplierNum`

and p.`PurchaseTime` BETWEEN SUBDATE(now(), INTERVAL 5 YEAR) and ADDDATE(SUBDATE(now(), INTERVAL 5 YEAR), INTERVAL 3 DAY)
GROUP BY (c.`CustomerNum`);";
    
    $result = mysqli_query($conn,$sql);
    echo "<table>
            <tr>
                <th>Purchase Number</th>
                <th>Purchase Time</th>
                <th>Customer Number</th>
                <th>Customer Name</th>
                
                
                <th>Number of different items</th>
                <th>Total Amount</th>
                <th>Shipping company number</th>

            </tr>";
    
    if(!empty(mysqli_fetch_array($result))){
    while ($row = mysqli_fetch_array($result)){
        echo "<tr><td>" . $row[0].
            "</td><td>" .$row[1].
            "</td><td>" .$row[2]."</td><td>" .
            $row[3]."</td><td>" .
            $row[4]."</td><td>" .$row[5]."</td><td>" .$row[6]. "</td></tr>";
        
        }}
        
    echo "</table>";   
    
    
    ?>
    
    </center>
    

</body>
</html>