<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div class="Settingscontainer clearfix">
    <div id="SettingsnavigationBar">
        <div id="setsUserPicture"><img src="data:image/jpeg;base64,<?php echo base64_encode($image) ?>" width="100" height="100" alt=""></div>
        <div id="setsUserNames"><?php echo $Names?></div>
        <span id="setsUserType"><?php echo $user_type; ?><span><img src="<?php echo URL ?>pictures/verify.png" width="13" height="13"></span></span>
    
      <div id="setsNav">
            <ul>
                <li id="settingsAccountNav"><a href="<?php echo URL ?>settings">Account</a></li>
                <li id="settingsPasswordNav" onclick="loadPasswordChange()">Password</li>
            </ul>
      </div>
    </div>
    
    <div id="settingsContainer">
        <div id="settingsConHeading">Account <span id="deactivateAcc"><a onclick="deactivateAcc()">Deactivate My Account</a></span><br>
            <span id="SettingsheadingDetails">Change your account details</span>
        </div>
        
        <div id="SettingsDetailsHolder">
            <div id="setsAccount">
                 <form action ="" method ="post" enctype="multipart/form-data" id="Settingsusrform">   
                     <span>First Name </span><input type="text" name="firstName" value="<?php echo " ".$firstName ?>" id="FirstNAME"/></br>
                     <span>Last Name</span> <input type="text" name="lastName"  value="<?php echo " ".$lastName ?>" id="LastNAME"/></br>
                     <span id="email">Email</span> <input type="email" name="email"  value="<?php echo $email ?>" id="EMAIL"/></br>
                     <span id="DOB">DOB</span> <select size="1" name="edob" id="YEAR">
                                <option><?php echo substr($DOB, ZERO, strlen($DOB)-6); ?></option>
                                <option>1930</option>
                                <option>1931</option>
                                <option>1932</option>
                                <option>1932</option>
                                <option>1933</option>
                                <option>1934</option>
                                <option>1935</option>
                                <option>1936</option>
                                <option>1937</option>
                                <option>1938</option>
                                <option>1939</option>
                                <option>1940</option>
                                <option>1941</option>
                                <option>1942</option>
                                <option>1942</option>
                                <option>1943</option>
                                <option>1944</option>
                                <option>1945</option>
                                <option>1946</option>
                                <option>1947</option>
                                <option>1948</option>
                                <option>1949</option>
                                <option>1950</option>
                                <option>1951</option>
                                <option>1952</option>
                                <option>1952</option>
                                <option>1953</option>
                                <option>1954</option>
                                <option>1955</option>
                                <option>1956</option>
                                <option>1957</option>
                                <option>1958</option>
                                <option>1959</option>
                                <option>1960</option>
                                <option>1961</option>
                                <option>1962</option>
                                <option>1962</option>
                                <option>1963</option>
                                <option>1964</option>
                                <option>1965</option>
                                <option>1966</option>
                                <option>1967</option>
                                <option>1968</option>
                                <option>1969</option>
                                <option>1970</option>
                                <option>1971</option>
                                <option>1972</option>
                                <option>1972</option>
                                <option>1973</option>
                                <option>1974</option>
                                <option>1975</option>
                                <option>1976</option>
                                <option>1977</option>
                                <option>1978</option>
                                <option>1979</option>
                                <option>1980</option>
                                <option>1981</option>
                                <option>1982</option>
                                <option>1982</option>
                                <option>1983</option>
                                <option>1984</option>
                                <option>1985</option>
                                <option>1986</option>
                                <option>1987</option>
                                <option>1988</option>
                                <option>1989</option>
                                <option>1990</option>
                                <option>1991</option>
                                <option>1992</option>
                                <option>1993</option>
                                <option>1994</option>
                                <option>1995</option>
                                <option>1996</option>
                                <option>1997</option>
                                <option>1998</option>
                                <option>1999</option>
                                <option>2000</option>
                                <option>2001</option>
                                <option>2002</option>
                                <option>2003</option>
                                <option>2004</option>
                                <option>2005</option>
                                <option>2006</option>
                                <option>2007</option>
                                <option>2008</option>
                                <option>2009</option>
                                <option>2010</option>
                                <option>2011</option>
                                <option>2012</option>
                                <option>2013</option>
                                <option>2014</option>
                             </select>
                     <select size="1" name="edob"  id="MONTH">
                        <option><?php echo substr($DOB, 5, count($DOB)-4); ?></option>
                         <option>01</option>
                         <option>02</option>
                         <option>03</option>
                         <option>04</option>
                         <option>05</option>
                         <option>06</option>
                         <option>07</option>
                         <option>08</option>
                         <option>09</option>
                         <option>10</option>
                         <option>11</option>
                         <option>12</option>
                      </select>
                     <select size="1" name="edob"  id="DAY">
                         <option><?php echo substr($DOB, 8, strlen($DOB)); ?></option>
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
                        <option>06</option>
                        <option>07</option>
                        <option>08</option>
                        <option>09</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                        <option>21</option>
                        <option>22</option>
                        <option>23</option>
                        <option>24</option>
                        <option>25</option>
                        <option>26</option>
                        <option>27</option>
                        <option>28</option>
                        <option>29</option>
                        <option>30</option>
                        <option>31</option>
                     </select> <br>
                     
                      <button onclick="updateInfo()" id="setssubmitBt" type="submit" name='submit' form="usrform">Save Changes</button>
                 </form>
            </div>
        </div>
        
        
        <!--
        password design starts here
        -->
       
        
        
    </div>
    
</div>

<!---
        error dialog box start here
        -->
        <div id="error_layer"></div>   
         <div id="error_dialog">
             <div id="header_dialog"><span class ="txt">Info Box</span></div>
             <div id="er_message"></div>
            <div id="error_close">| x |</div>
        </div>
        
        <!---
        
  <!---
        error dialog box start here
        -->
        <div id="passwordDialog_layer"></div>   
         <div id="password_dialog">
             <div id="passwordDialogheader_dialog"><span class ="txt">Password Confirmation</span></div>
             <div id="passwordDialog_message">
                 <div id="NoPwordErrorMessage"></div>
                 <form action ="" method ="post" enctype="multipart/form-data" id="PwordConfirmationsusrform">
                     <span>Password</span><input type="password" id="updatePwordConfimation"/><br>
                     <button id="PwordConfirmsubmitBt" type="submit" name='submit' form="usrform">Confirm</button><span id="ajax_loader_pwConfirm"></span>
                 </form>
             </div>
            <div id="passwordDialog_close">| x |</div>
        </div>
        
        <!---