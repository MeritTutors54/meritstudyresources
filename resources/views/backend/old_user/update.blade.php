@extends('layouts.backend')
@section('content')
@php
date_default_timezone_set("asia/dhaka");
$current = date("m/d/Y");
@endphp

<div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                                        </i>
                                    </div>
                                    <div>Update Customer</div>
                                </div>
                                <div class="page-title-actions">

                                    <div class="d-inline-block dropdown">
                                      <a href="{{route('admin.user.index')}}">
                                        <button type="button" class="btn-shadow dropdown-toggle btn btn-info">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">

                                            </span>
                                            All Customer
                                        </button>
                                      </a>
                                    </div>
                                </div>

                            </div>
                        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <form action="{{route('admin.user.update')}}" method="POST" enctype='multipart/form-data'>
                @csrf
                <div class="row">
                    <div class="col-md-9">
                        <div class="card shadow-sm shadow-showcase">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Customer Content</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">Name: <span style="color:red">*</span></label>
                                            <input type="text" class="form-control"  name="name" placeholder="Name" value="{{$edit->name}}"/>
                                            <input type="hidden" name="id"  value="{{$edit->id}}"/>
                                            @error('name')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">Phone:<span style="color:red">*</span></label>
                                            <input type="text" class="form-control"  name="phone" placeholder="Phone"  value="{{$edit->phone}}"/>
                                            @error('phone')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">Email:<span style="color:red">*</span></label>
                                            <input type="email" class="form-control"  name="email" placeholder="Email" value="{{$edit->email}}"/>
                                            @error('email')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">Current Country:</label>
                                            <select class="form-control" name="country">
<option value="Afghanistan" @if($edit->country=='Afghanistan') selected @endif>Afghanistan</option>
<option value="Albania" @if($edit->country=='Albania') selected @endif>Albania</option>
<option value="Algeria" @if($edit->country=='Algeria') selected @endif>Algeria</option>
<option value="American Samoa" @if($edit->country=='American Samoa') selected @endif>American Samoa</option>
<option value="Andorra" @if($edit->country=='Andorra') selected @endif>Andorra</option>
<option value="Angola" @if($edit->country=='Angola') selected @endif>Angola</option>
<option value="Anguilla" @if($edit->country=='Anguilla') selected @endif>Anguilla</option>
<option value="Antartica" @if($edit->country=='Antartica') selected @endif>Antarctica</option>
<option value="Antigua and Barbuda" @if($edit->country=='Antigua and Barbuda') selected @endif>Antigua and Barbuda</option>
<option value="Argentina"@if($edit->country=='Argentina') selected @endif>Argentina</option>
<option value="Armenia"@if($edit->country=='Armenia') selected @endif>Armenia</option>
<option value="Aruba"@if($edit->country=='Aruba') selected @endif>Aruba</option>
<option value="Australia"@if($edit->country=='Australia') selected @endif>Australia</option>
<option value="Austria"@if($edit->country=='Austria') selected @endif>Austria</option>
<option value="Azerbaijan"@if($edit->country=='Azerbaijan') selected @endif>Azerbaijan</option>
<option value="Bahamas"@if($edit->country=='Bahamas') selected @endif>Bahamas</option>
<option value="Bahrain"@if($edit->country=='Bahrain') selected @endif>Bahrain</option>
<option value="Bangladesh"@if($edit->country=='Bangladesh') selected @endif>Bangladesh</option>
<option value="Barbados"@if($edit->country=='Barbados') selected @endif>Barbados</option>
<option value="Belarus"@if($edit->country=='Belarus') selected @endif>Belarus</option>
<option value="Belgium"@if($edit->country=='Belgium') selected @endif>Belgium</option>
<option value="Belize"@if($edit->country=='Belize') selected @endif>Belize</option>
<option value="Benin"@if($edit->country=='Benin') selected @endif>Benin</option>
<option value="Bermuda"@if($edit->country=='Bermuda') selected @endif>Bermuda</option>
<option value="Bhutan"@if($edit->country=='Bhutan') selected @endif>Bhutan</option>
<option value="Bolivia"@if($edit->country=='Bolivia') selected @endif>Bolivia</option>
<option value="Bosnia and Herzegowina"@if($edit->country=='Bosnia and Herzegowina') selected @endif>Bosnia and Herzegowina</option>
<option value="Botswana"@if($edit->country=='Botswana') selected @endif>Botswana</option>
<option value="Bouvet Island"@if($edit->country=='Bouvet Island') selected @endif>Bouvet Island</option>
<option value="Brazil"@if($edit->country=='Brazil') selected @endif>Brazil</option>
<option value="British Indian Ocean Territory"@if($edit->country=='British Indian Ocean Territory') selected @endif>British Indian Ocean Territory</option>
<option value="Brunei Darussalam"@if($edit->country=='Brunei Darussalam') selected @endif>Brunei Darussalam</option>
<option value="Bulgaria"@if($edit->country=='Bulgaria') selected @endif>Bulgaria</option>
<option value="Burkina Faso"@if($edit->country=='Burkina Faso') selected @endif>Burkina Faso</option>
<option value="Burundi"@if($edit->country=='Burundi') selected @endif>Burundi</option>
<option value="Cambodia"@if($edit->country=='Cambodia') selected @endif>Cambodia</option>
<option value="Cameroon"@if($edit->country=='Cameroon') selected @endif>Cameroon</option>
<option value="Canada"@if($edit->country=='Canada') selected @endif>Canada</option>
<option value="Cape Verde"@if($edit->country=='Cape Verde') selected @endif>Cape Verde</option>
<option value="Cayman Islands"@if($edit->country=='Cayman Islands') selected @endif>Cayman Islands</option>
<option value="Central African Republic"@if($edit->country=='Central African Republic') selected @endif>Central African Republic</option>
<option value="Chad"@if($edit->country=='Chad') selected @endif>Chad</option>
<option value="Chile"@if($edit->country=='Chile') selected @endif>Chile</option>
<option value="China"@if($edit->country=='China') selected @endif>China</option>
<option value="Christmas Island"@if($edit->country=='Christmas Island') selected @endif>Christmas Island</option>

<option value="Cocos Islands"@if($edit->country=='Cocos Islands') selected @endif>Cocos (Keeling) Islands</option>
<option value="Colombia"@if($edit->country=='Colombia') selected @endif>Colombia</option>
<option value="Comoros"@if($edit->country=='Comoros') selected @endif>Comoros</option>
<option value="Congo"@if($edit->country=='Congo') selected @endif>Congo</option>
<option value="Congo the Democratic Republic of the"@if($edit->country=='Congo the Democratic Republic of the') selected @endif>Congo, the Democratic Republic of the</option>
<option value="Cook Islands"@if($edit->country=='Cook Islands') selected @endif>Cook Islands</option>
<option value="Costa Rica"@if($edit->country=='Costa Rica') selected @endif>Costa Rica</option>
<option value="Cota D'Ivoire"@if($edit->country=="Cota D'Ivoire") selected @endif>Cote d'Ivoire</option>
<option value="Croatia"@if($edit->country=='Croatia') selected @endif>Croatia (Hrvatska)</option>

<option value="Cuba"@if($edit->country=='Cuba') selected @endif>Cuba</option>
<option value="Cyprus"@if($edit->country=='Cyprus') selected @endif>Cyprus</option>
<option value="Czech Republic"@if($edit->country=='Czech Republic') selected @endif>Czech Republic</option>
<option value="Denmark"@if($edit->country=='Denmark') selected @endif>Denmark</option>
<option value="Djibouti"@if($edit->country=='Djibouti') selected @endif>Djibouti</option>
<option value="Dominica"@if($edit->country=='Dominica') selected @endif>Dominica</option>
<option value="Dominican Republic"@if($edit->country=='Dominican Republic') selected @endif>Dominican Republic</option>
<option value="East Timor"@if($edit->country=='East Timor') selected @endif>East Timor</option>
<option value="Ecuador"@if($edit->country=='Ecuador') selected @endif>Ecuador</option>
<option value="Egypt"@if($edit->country=='Egypt') selected @endif>Egypt</option>
<option value="El Salvador"@if($edit->country=='El Salvador') selected @endif>El Salvador</option>

<option value="Equatorial Guinea"@if($edit->country=='Equatorial Guinea') selected @endif>Equatorial Guinea</option>
<option value="Eritrea"@if($edit->country=='Eritrea') selected @endif>Eritrea</option>
<option value="Estonia"@if($edit->country=='Estonia') selected @endif>Estonia</option>
<option value="Ethiopia"@if($edit->country=='Ethiopia') selected @endif>Ethiopia</option>
<option value="Falkland Islands"@if($edit->country=='Falkland Islands') selected @endif>Falkland Islands (Malvinas)</option>
<option value="Faroe Islands"@if($edit->country=='Faroe Islands') selected @endif>Faroe Islands</option>
<option value="Fiji"@if($edit->country=='Fiji') selected @endif>Fiji</option>
<option value="Finland"@if($edit->country=='Finland') selected @endif>Finland</option>
<option value="France"@if($edit->country=='France') selected @endif>France</option>
<option value="France Metropolitan"@if($edit->country=='rance Metropolitan') selected @endif>France, Metropolitan</option>
<option value="French Guiana"@if($edit->country=='French Guiana') selected @endif>French Guiana</option>
<option value="French Polynesia"@if($edit->country=='French Polynesia') selected @endif>French Polynesia</option>
<option value="French Southern Territories"@if($edit->country=='French Southern Territories') selected @endif>French Southern Territories</option>
<option value="Gabon"@if($edit->country=='Gabon') selected @endif>Gabon</option>
<option value="Gambia"@if($edit->country=='Gambia') selected @endif>Gambia</option>
<option value="Georgia"@if($edit->country=='Georgia') selected @endif>Georgia</option>
<option value="Germany"@if($edit->country=='Germany') selected @endif>Germany</option>
<option value="Ghana"@if($edit->country=='Ghana') selected @endif>Ghana</option>
<option value="Gibraltar"@if($edit->country=='Gibraltar') selected @endif>Gibraltar</option>
<option value="Greece"@if($edit->country=='Greece') selected @endif>Greece</option>
<option value="Greenland"@if($edit->country=='Greenland') selected @endif>Greenland</option>
<option value="Grenada"@if($edit->country=='Grenada') selected @endif>Grenada</option>
<option value="Guadeloupe"@if($edit->country=='Guadeloupe') selected @endif>Guadeloupe</option>
<option value="Guam"@if($edit->country=='Guam') selected @endif>Guam</option>
<option value="Guatemala"@if($edit->country=='Guatemala') selected @endif>Guatemala</option>
<option value="Guinea"@if($edit->country=='Guinea') selected @endif>Guinea</option>
<option value="Guinea-Bissau"@if($edit->country=='Guinea-Bissau') selected @endif>Guinea-Bissau</option>
<option value="Guyana"@if($edit->country=='Guyana') selected @endif>Guyana</option>
<option value="Haiti"@if($edit->country=='Haiti') selected @endif>Haiti</option>
<option value="Heard and McDonald Islands"@if($edit->country=='Heard and McDonald Islands') selected @endif>Heard and Mc Donald Islands</option>
<option value="Holy See"@if($edit->country=='Holy See') selected @endif>Holy See (Vatican City State)</option>
<option value="Honduras"@if($edit->country=='Honduras') selected @endif>Honduras</option>
<option value="Hong Kong"@if($edit->country=='Hong Kong') selected @endif>Hong Kong</option>
<option value="Hungary"@if($edit->country=='Hungary') selected @endif>Hungary</option>
<option value="Iceland"@if($edit->country=='Iceland') selected @endif>Iceland</option>
<option value="India"@if($edit->country=='India') selected @endif>India</option>
<option value="Indonesia"@if($edit->country=='Indonesia') selected @endif>Indonesia</option>
<option value="Iran"@if($edit->country=='Iran') selected @endif>Iran (Islamic Republic of)</option>
<option value="Iraq"@if($edit->country=='Iraq') selected @endif>Iraq</option>
<option value="Ireland"@if($edit->country=='Ireland') selected @endif>Ireland</option>
<option value="Israel"@if($edit->country=='Israel') selected @endif>Israel</option>
<option value="Italy"@if($edit->country=='Italy') selected @endif>Italy</option>

<option value="Jamaica"@if($edit->country=='Jamaica') selected @endif>Jamaica</option>
<option value="Japan"@if($edit->country=='Japan') selected @endif>Japan</option>
<option value="Jordan"@if($edit->country=='Jordan') selected @endif>Jordan</option>
<option value="Kazakhstan"@if($edit->country=='Kazakhstan') selected @endif>Kazakhstan</option>
<option value="Kenya"@if($edit->country=='Kenya') selected @endif>Kenya</option>
<option value="Kiribati"@if($edit->country=='Kiribati') selected @endif>Kiribati</option>
<option value="Democratic People's Republic of Korea"@if($edit->country=="Democratic People's Republic of Korea") selected @endif>Korea, Democratic People's Republic of</option>
<option value="Korea"@if($edit->country=='Korea') selected @endif>Korea, Republic of</option>
<option value="Kuwait"@if($edit->country=='Kuwait') selected @endif>Kuwait</option>
<option value="Kyrgyzstan"@if($edit->country=='Kyrgyzstan') selected @endif>Kyrgyzstan</option>
<option value="Lao"@if($edit->country=='Lao') selected @endif>Lao People's Democratic Republic</option>
<option value="Latvia"@if($edit->country=='Latvia') selected @endif>Latvia</option>
<option value="Lebanon" @if($edit->country=='Lebanon') selected @endif>Lebanon</option>
<option value="Lesotho"@if($edit->country=='Lesotho') selected @endif>Lesotho</option>
<option value="Liberia"@if($edit->country=='Liberia') selected @endif>Liberia</option>
<option value="Libyan Arab Jamahiriya"@if($edit->country=='Libyan Arab Jamahiriya') selected @endif>Libyan Arab Jamahiriya</option>
<option value="Liechtenstein"@if($edit->country=='Liechtenstein') selected @endif>Liechtenstein</option>
<option value="Lithuania"@if($edit->country=='Lithuania') selected @endif>Lithuania</option>
<option value="Luxembourg"@if($edit->country=='Luxembourg') selected @endif>Luxembourg</option>
<option value="Macau"@if($edit->country=='Macau') selected @endif>Macau</option>
<option value="Macedonia"@if($edit->country=='Macedonia') selected @endif>Macedonia, The Former Yugoslav Republic of</option>
<option value="Madagascar"@if($edit->country=='Madagascar') selected @endif>Madagascar</option>
<option value="Malawi"@if($edit->country=='Malawi') selected @endif>Malawi</option>
<option value="Malaysia"@if($edit->country=='Malaysia') selected @endif>Malaysia</option>
<option value="Maldives"@if($edit->country=='Maldives') selected @endif>Maldives</option>
<option value="Mali"@if($edit->country=='Mali') selected @endif>Mali</option>
<option value="Malta"@if($edit->country=='Malta') selected @endif>Malta</option>
<option value="Marshall Islands"@if($edit->country=='Marshall Islands') selected @endif>Marshall Islands</option>
<option value="Martinique"@if($edit->country=='Martinique') selected @endif>Martinique</option>
<option value="Mauritania"@if($edit->country=='Mauritania') selected @endif>Mauritania</option>
<option value="Mauritius"@if($edit->country=='Mauritius') selected @endif>Mauritius</option>
<option value="Mayotte"@if($edit->country=='Mayotte') selected @endif>Mayotte</option>
<option value="Mexico"@if($edit->country=='Mexico') selected @endif>Mexico</option>
<option value="Micronesia"@if($edit->country=='Micronesia') selected @endif>Micronesia, Federated States of</option>
<option value="Moldova"@if($edit->country=='Moldova') selected @endif>Moldova, Republic of</option>
<option value="Monaco"@if($edit->country=='Monaco') selected @endif>Monaco</option>
<option value="Mongolia"@if($edit->country=='Mongolia') selected @endif>Mongolia</option>
<option value="Montserrat"@if($edit->country=='Montserrat') selected @endif>Montserrat</option>
<option value="Morocco"@if($edit->country=='Morocco') selected @endif>Morocco</option>
<option value="Mozambique"@if($edit->country=='Mozambique') selected @endif>Mozambique</option>
<option value="Myanmar"@if($edit->country=='Myanmar') selected @endif>Myanmar</option>
<option value="Namibia"@if($edit->country=='Namibia') selected @endif>Namibia</option>
<option value="Nauru"@if($edit->country=='Nauru') selected @endif>Nauru</option>
<option value="Nepal"@if($edit->country=='Nepal') selected @endif>Nepal</option>
<option value="Netherlands"@if($edit->country=='Netherlands') selected @endif>Netherlands</option>
<option value="Netherlands Antilles"@if($edit->country=='Netherlands Antilles') selected @endif>Netherlands Antilles</option>

<option value="New Caledonia"@if($edit->country=='New Caledonia') selected @endif>New Caledonia</option>
<option value="New Zealand"@if($edit->country=='New Zealand') selected @endif>New Zealand</option>
<option value="Nicaragua"@if($edit->country=='Nicaragua') selected @endif>Nicaragua</option>
<option value="Niger"@if($edit->country=='Niger') selected @endif>Niger</option>
<option value="Nigeria"@if($edit->country=='Nigeria') selected @endif>Nigeria</option>
<option value="Niue"@if($edit->country=='Niue') selected @endif>Niue</option>
<option value="Norfolk Island"@if($edit->country=='Norfolk Island') selected @endif>Norfolk Island</option>
<option value="Northern Mariana Islands"@if($edit->country=='Northern Mariana Islands') selected @endif>Northern Mariana Islands</option>
<option value="Norway"@if($edit->country=='Norway') selected @endif>Norway</option>
<option value="Oman"@if($edit->country=='Oman') selected @endif>Oman</option>
<option value="Pakistan"@if($edit->country=='Pakistan') selected @endif>Pakistan</option>
<option value="Palau"@if($edit->country=='Palau') selected @endif>Palau</option>
<option value="Panama"@if($edit->country=='Panama') selected @endif>Panama</option>
<option value="Papua New Guinea"@if($edit->country=='Papua New Guinea') selected @endif>Papua New Guinea</option>
<option value="Paraguay"@if($edit->country=='Paraguay') selected @endif>Paraguay</option>

<option value="Peru"@if($edit->country=='Peru') selected @endif>Peru</option>
<option value="Philippines"@if($edit->country=='Philippines') selected @endif>Philippines</option>
<option value="Pitcairn"@if($edit->country=='Pitcairn') selected @endif>Pitcairn</option>
<option value="Poland"@if($edit->country=='Poland') selected @endif>Poland</option>
<option value="Portugal"@if($edit->country=='Portugal') selected @endif>Portugal</option>
<option value="Puerto Rico"@if($edit->country=='Puerto Rico') selected @endif>Puerto Rico</option>
<option value="Qatar"@if($edit->country=='Qatar') selected @endif>Qatar</option>
<option value="Reunion"@if($edit->country=='Reunion') selected @endif>Reunion</option>
<option value="Romania"@if($edit->country=='Romania') selected @endif>Romania</option>
<option value="Russia"@if($edit->country=='Russia') selected @endif>Russian Federation</option>
<option value="Rwanda"@if($edit->country=='Rwanda') selected @endif>Rwanda</option>
<option value="Saint Kitts and Nevis"@if($edit->country=='Saint Kitts and Nevis') selected @endif>Saint Kitts and Nevis</option> 
<option value="Saint LUCIA"@if($edit->country=='Saint LUCIA') selected @endif>Saint LUCIA</option>
<option value="Saint Vincent"@if($edit->country=='Saint Vincent') selected @endif>Saint Vincent and the Grenadines</option>
<option value="Samoa"@if($edit->country=='Samoa') selected @endif>Samoa</option>
<option value="San Marino"@if($edit->country=='San Marino') selected @endif>San Marino</option>

<option value="Sao Tome and Principe"@if($edit->country=='Sao Tome and Principe') selected @endif>Sao Tome and Principe</option> 
<option value="Saudi Arabia"@if($edit->country=='Saudi Arabia') selected @endif>Saudi Arabia</option>
<option value="Senegal"@if($edit->country=='Senegal') selected @endif>Senegal</option>
<option value="Seychelles"@if($edit->country=='Seychelles') selected @endif>Seychelles</option>
<option value="Sierra"@if($edit->country=='Sierra') selected @endif>Sierra Leone</option>
<option value="Singapore"@if($edit->country=='Singapore') selected @endif>Singapore</option>
<option value="Slovakia"@if($edit->country=='Slovakia') selected @endif>Slovakia (Slovak Republic)</option>
<option value="Slovenia"@if($edit->country=='Slovenia') selected @endif>Slovenia</option>
<option value="Solomon Islands"@if($edit->country=='Solomon Islands') selected @endif>Solomon Islands</option>
<option value="Somalia"@if($edit->country=='Somalia') selected @endif>Somalia</option>
<option value="South Africa"@if($edit->country=='South Africa') selected @endif>South Africa</option>
<option value="South Georgia"@if($edit->country=='South Georgia') selected @endif>South Georgia and the South Sandwich Islands</option>
<option value="Span"@if($edit->country=='Span') selected @endif>Spain</option>
<option value="SriLanka"@if($edit->country=='SriLanka') selected @endif>Sri Lanka</option>
<option value="St. Helena"@if($edit->country=='St. Helena') selected @endif>St. Helena</option>
<option value="St. Pierre and Miguelon"@if($edit->country=='St. Pierre and Miguelon') selected @endif>St. Pierre and Miquelon</option>
<option value="Sudan"@if($edit->country=='Sudan') selected @endif>Sudan</option>
<option value="Suriname"@if($edit->country=='Suriname') selected @endif>Suriname</option>
<option value="Svalbard"@if($edit->country=='Svalbard') selected @endif>Svalbard and Jan Mayen Islands</option>
<option value="Swaziland"@if($edit->country=='Swaziland') selected @endif>Swaziland</option>
<option value="Sweden"@if($edit->country=='Sweden') selected @endif>Sweden</option>
<option value="Switzerland"@if($edit->country=='Switzerland') selected @endif>Switzerland</option>
<option value="Syria"@if($edit->country=='Syria') selected @endif>Syrian Arab Republic</option>
<option value="Taiwan"@if($edit->country=='Taiwan') selected @endif>Taiwan, Province of China</option>
<option value="Tajikistan"@if($edit->country=='Tajikistan') selected @endif>Tajikistan</option>
<option value="Tanzania"@if($edit->country=='Tanzania') selected @endif>Tanzania, United Republic of</option>
<option value="Thailand"@if($edit->country=='Thailand') selected @endif>Thailand</option>
<option value="Togo"@if($edit->country=='Togo') selected @endif>Togo</option>
<option value="Tokelau"@if($edit->country=='Tokelau') selected @endif>Tokelau</option>
<option value="Tonga"@if($edit->country=='Tonga') selected @endif>Tonga</option>
<option value="Trinidad and Tobago"@if($edit->country=='Trinidad and Tobago') selected @endif>Trinidad and Tobago</option>
<option value="Tunisia"@if($edit->country=='Tunisia') selected @endif>Tunisia</option>
<option value="Turkey"@if($edit->country=='Turkey') selected @endif>Turkey</option>
<option value="Turkmenistan"@if($edit->country=='Turkmenistan') selected @endif>Turkmenistan</option>

<option value="Turks and Caicos"@if($edit->country=='Turks and Caicos') selected @endif>Turks and Caicos Islands</option>
<option value="Tuvalu"@if($edit->country=='Tuvalu') selected @endif>Tuvalu</option>
<option value="Uganda"@if($edit->country=='Uganda') selected @endif>Uganda</option>
<option value="Ukraine"@if($edit->country=='Ukraine') selected @endif>Ukraine</option>
<option value="United Arab Emirates"@if($edit->country=='United Arab Emirates') selected @endif>United Arab Emirates</option>
<option value="United Kingdom"@if($edit->country=='United Kingdom') selected @endif>United Kingdom</option>
<option value="United States"@if($edit->country=='United States') selected @endif>United States</option>
<option value="United States Minor Outlying Islands"@if($edit->country=='United States Minor Outlying Islands') selected @endif>United States Minor Outlying Islands</option>
<option value="Uruguay"@if($edit->country=='Uruguay') selected @endif>Uruguay</option>
<option value="Uzbekistan"@if($edit->country=='Uzbekistan') selected @endif>Uzbekistan</option>
<option value="Vanuatu"@if($edit->country=='Vanuatu') selected @endif>Vanuatu</option>
<option value="Venezuela"@if($edit->country=='Venezuela') selected @endif>Venezuela</option>
<option value="Vietnam"@if($edit->country=='Vietnam') selected @endif>Viet Nam</option>
<option value="Virgin Islands (British)"@if($edit->country=='Virgin Islands (British)') selected @endif>Virgin Islands (British)</option>
<option value="Virgin Islands (U.S)"@if($edit->country=='Virgin Islands (U.S)') selected @endif>Virgin Islands (U.S.)</option>
<option value="Wallis and Futana Islands"@if($edit->country=='Wallis and Futana Islands') selected @endif>Wallis and Futuna Islands</option>
<option value="Western Sahara"@if($edit->country=='Western Sahara') selected @endif>Western Sahara</option>
<option value="Yemen"@if($edit->country=='Yemen') selected @endif>Yemen</option>
<option value="Serbia"@if($edit->country=='Serbia') selected @endif>Serbia</option>
<option value="Zambia"@if($edit->country=='Zambia') selected @endif>Zambia</option>
<option value="Zimbabwe"@if($edit->country=='Zimbabwe') selected @endif>Zimbabwe</option>
</select>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">Balance:</label>
                                           <Input type="number" name="balance" class="form-control"  placeholder="Balance" value="{{ $edit->balance }}">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">Payable / Receivable:</label>
                                           <select name="payable_or_receivable" class="form-control">
                                               <option value="Payable" @if($edit->payable_or_receivable=="Payable") selected @endif>Payable</option>
                                               <option value="Receivable" @if($edit->payable_or_receivable=="Receivable") selected @endif>Receivable</option>
                                           </select>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm shadow-showcase">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Extra</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fname">Address:</label>
                                           <textarea type="text" name="address" class="form-control">{{ $edit->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-sm shadow-showcase">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-md-12">
                                        <div class="custom-control custom-radio custom-radio-color-checked custom-control">
                                            <input type="radio" name="is_active" id="customRadio-8" class="custom-control-input bg-primary" value="1" @if($edit->is_active==1) checked @endif>
                                            <label class="custom-control-label" for="customRadio-8"> Active </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-radio-color-checked custom-control mt-1">
                                            <input type="radio" name="is_active" id="customRadio-9" name="customRadio-10" class="custom-control-input bg-warning" value="0"  @if($edit->is_active==0) checked @endif>
                                            <label class="custom-control-label" for="customRadio-9"> Deactive </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-sm shadow-showcase">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="file-upload-form" class="">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>

        </div>
    </div>
</div>
</div>


@endsection
