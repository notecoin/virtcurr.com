// JS Document
function UpdateDetails(ex){
	var delay = 5000;
	var now, before = new Date();
	GetDetails(ex);
	setInterval(function() {
    now = new Date();
    var elapsedTime = (now.getTime() - before.getTime());
    GetDetails(ex);
    before = new Date();    
}, 5000);
	
}
function GetDetails(ex){
	user_id = $("#User_ID").html();
	if(ex=="/EX/DASHBOARD"){ex = "BTC/LTC";}
	$.getJSON('/Updates/Rates/'+ex,
		function(ReturnValues){
			if(ReturnValues['Refresh']=="Yes"){
					$.getJSON('/Updates/Orders/'+ex,
						function(Orders){
							$('#BuyOrders').html(Orders['BuyOrdersHTML']);
							$('#SellOrders').html(Orders['SellOrdersHTML']);							
					});
					$.getJSON('/Updates/YourOrders/'+ex+'/'+user_id,
						function(Orders){
							$('#YourCompleteOrders').html(Orders['YourCompleteOrdersHTML']);
							$('#YourOrders').html(Orders['YourOrdersHTML']);							
					});
			}
			
			$("#LowPrice").html(ReturnValues['Low']);
			$("#HighPrice").html(ReturnValues['High']);					
			$("#LowestAskPrice").html(ReturnValues['High']);	
			if($("#BuyPriceper").val()=="" || $("#BuyPriceper").val()==0){
				$("#BuyPriceper").val(ReturnValues['High']);
			}
			$("#HighestBidPrice").html(ReturnValues['Low']);
			if($("#SellPriceper").val()=="" || $("#SellPriceper").val()==0){
				$("#SellPriceper").val(ReturnValues['Low']);
			}
			$("#LastPrice").html(ReturnValues['Last']);
			Volume = ReturnValues['VolumeFirst'] + " " + ReturnValues['VolumeFirstUnit'] +
			" / " + ReturnValues['VolumeSecond'] + " " + ReturnValues['VolumeSecondUnit'];
			$("#Volume").html(Volume);					
		}
	);
}
function BuyFormCalculate (){
	BalanceSecond = $('#BalanceSecond').html();
	FirstCurrency = $('#BuyFirstCurrency').val();
	SecondCurrency = $('#BuySecondCurrency').val();
	UserName = $('#UserName').val();
	BuyAmount = $('#BuyAmount').val();
	BuyPriceper = $('#BuyPriceper').val();
	if(BuyAmount=="" || BuyAmount==0){return false;}
	if(BuyPriceper=="" || BuyPriceper==0){return false;}
	TotalValue = BuyAmount * BuyPriceper;
	TotalValue = TotalValue.toFixed(6);
	$("#BuyTotal").html(TotalValue);
	
	$.getJSON('/Updates/Commission/'+UserName,
		function(ReturnValues){
			$("#BuyCommission").val(ReturnValues['Commission']);			
			Commission = $('#BuyCommission').val();
			Fees = BuyAmount * Commission / 100;
			Fees = Fees.toFixed(5);
			$("#BuyFee").html(Fees);	
			$('#BuyCommissionAmount').val(Fees);
			$('#BuyCommissionCurrency').val(FirstCurrency);			
		}
	);
	GrandTotal = TotalValue;
	if(GrandTotal==0){
		BuySummary = "Amount cannot be Zero";
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").attr("disabled", "disabled");
		$("#BuySubmitButton").attr("class", "btn btn-warning btn-block");
		return false;
	}
	if(parseFloat(BalanceSecond) <= parseFloat(GrandTotal)){
		Excess = parseFloat(GrandTotal) - parseFloat(BalanceSecond);
		Excess = Excess.toFixed(5)		
		BuySummary = "The transaction amount exceeds the balance by " + Excess + " " + SecondCurrency;
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").attr("disabled", "disabled");
		$("#BuySubmitButton").attr("class", "btn btn-warning btn-block");
	}else{
		BuySummary = "The transaction amount " + GrandTotal  + " " + SecondCurrency;
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").removeAttr('disabled');
		$("#BuySubmitButton").attr("class", "btn btn-success btn-block");		
	}
	if(parseFloat(GrandTotal)===0){$("#BuySubmitButton").attr("disabled", "disabled");}
}
function SellFormCalculate (){
	BalanceFirst = $('#BalanceFirst').html();
	FirstCurrency = $('#SellFirstCurrency').val();
	SecondCurrency = $('#SellSecondCurrency').val();
	UserName = $('#UserName').val();
	SellAmount = $('#SellAmount').val();
	SellPriceper = $('#SellPriceper').val();
if(SellAmount=="" || SellAmount==0){return false;}
if(SellPriceper=="" || SellPriceper==0){return false;}

	TotalValue = SellAmount * SellPriceper;
	TotalValue = TotalValue.toFixed(6);
	$("#SellTotal").html(TotalValue);
	
	$.getJSON('/Updates/Commission/'+UserName,
		function(ReturnValues){
			$("#SellCommission").val(ReturnValues['Commission']);			
			Commission = $('#SellCommission').val();;	
			Fees = TotalValue * Commission / 100;
			Fees = Fees.toFixed(5);
			$("#SellFee").html(Fees);	
			$('#SellCommissionAmount').val(Fees);
			$('#SellCommissionCurrency').val(SecondCurrency);						
		}
	);

	GrandTotal = SellAmount;
	if(SellAmount==0){
	SellSummary = "Amount cannot be Zero";
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning btn-block");		
		return false;
	}

	if(parseFloat(BalanceFirst) < parseFloat(GrandTotal)){
		Excess =  parseFloat(GrandTotal) - parseFloat(BalanceFirst)  ;
		Excess = Excess.toFixed(5)
		SellSummary = "The transaction amount exceeds the balance by " + Excess + " " + FirstCurrency;
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning btn-block");				
	}else{
		SellSummary = "The transaction amount " + GrandTotal  + " " + FirstCurrency;
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").removeAttr('disabled');
		$("#SellSubmitButton").attr("class", "btn btn-success btn-block");				
	}
	if(parseFloat(GrandTotal)===0){$("#SellSubmitButton").attr("disabled", "disabled");}
}
function SellOrderFill(SellOrderPrice,SellOrderAmount){
	$("#BuyAmount").val(SellOrderAmount)  ;
	$("#BuyPriceper").val(SellOrderPrice)  ;
}
function BuyOrderFill(BuyOrderPrice,BuyOrderAmount){
	$("#SellAmount").val(BuyOrderAmount)  ;
	$("#SellPriceper").val(BuyOrderPrice)  ;
}
function ConvertBalance(){
	BTCRate = $("#BTCRate").val();
	LTCRate = $("#LTCRate").val();	
	USDRate = $("#USDRate").val();	
	GBPRate = $("#GBPRate").val();	
	EURRate = $("#EURRate").val();	
	Currency = $("#Currency" ).val();		
	switch(Currency){
		case "BTC":
		  break;
		case "LTC":
		  break;
		case "USD":
		  break;
		case "EUR":
		  break;
		case "GBP":
		  break;
	}
	
}
function SendPassword(){
	$.getJSON('/Users/SendPassword/'+$("#Username").val(),
		function(ReturnValues){
			$("#LoginEmailPassword").show();
			$("#UserNameIcon").attr("class", "glyphicon glyphicon-ok");
			if(ReturnValues['TOTP']=="Yes"){
				$("#TOTPPassword").show();
				}
			}
	);
}

function SaveTOTP(){
	if($("#ScannedCode").val()==""){return false;}
	$.getJSON('/Users/SaveTOTP/',{
			  Login:$("#Login").is(':checked'),
			  Withdrawal:$("#Withdrawal").is(':checked'),			  
			  Security:$("#Security").is(':checked'),
			  ScannedCode:$("#ScannedCode").val()
			  },
		function(ReturnValues){
			if(ReturnValues){
				window.location.assign("/users/settings");				
			}			
		}
	);
}
function CheckTOTP(){
	if($("#CheckCode").val()==""){return false;}
	$.getJSON('/Users/CheckTOTP/',{
			  CheckCode:$("#CheckCode").val()
			  },
		function(ReturnValues){
			if(ReturnValues){
				window.location.assign("/users/settings");		
			}
		}
	);
}


function DeleteTOTP(){
	$.getJSON('/Users/DeleteTOTP/',
		function(ReturnValues){}
	);	
}
function CheckPayment(){
	$("#BTCAlert").hide();
	address = $("#bitcoinaddress").val();
	if(address==""){
		$("#BTCAlert").html("Address incorrect"); 	
		$("#BTCAlert").show();
		return false;}
	amount = $("#Amount").val();
	if(amount==""){
		$("#BTCAlert").html("Not sufficient balance"); 	
		$("#BTCAlert").show();
		return false;}
	maxValue = $("#maxValue").val();
	if(parseFloat(amount)>parseFloat(maxValue)){
		$("#BTCAlert").html("Not sufficient balance"); 	
		$("#BTCAlert").show();
		return false;
		}
	
	$("#SendFees").html($("#txFee").val());

	$("#SendAmount").html(amount);	
	$("#SendTotal").html(parseFloat(amount)-parseFloat($("#txFee").val()));	
	$("#TransferAmount").val(parseFloat(amount)-parseFloat($("#txFee").val()));

	$.getJSON('/Updates/Address/'+address,
		function(ReturnValues){
			if(ReturnValues['verify']['isvalid']==true){
			address = "<a href='http://blockchain.info/address/"+ address +"' target='_blank'>"+ address +"</a> <i class='glyphicon glyphicon-ok'></i>";
			$("#SendAddress").html(address); 	
			$("#SendSuccessButton").removeAttr('disabled');				
				}
		});
	return true;
	}
	
function BitCoinAddress(){
	address = $("#bitcoinaddress").val();
  $("#SendAddress").html(address); 	
	SuccessButtonDisable();
	}
function SuccessButtonDisable(){
	$("#SendSuccessButton").attr("disabled", "disabled");
	}
function CheckDeposit(){
	AmountFiat = $("#AmountFiat").val();
	Currency = $("#Currency").val();

	if(AmountFiat==""){
		$("#Alert").hide();
		$("#Alert").html("Please enter amount"); 			
		$("#Alert").show();
		return false;}
	if(Currency==""){
		$("#Alert").hide();
		$("#Alert").html("Please select currency"); 			
		$("#Alert").show();
		return false;}
	
	}
function CheckWithdrawal(){
	WithdrawAmountFiat = $("#WithdrawAmountFiat").val();
	WithdrawCurrency = $("#WithdrawCurrency").val();	
	if(WithdrawAmountFiat==""){
		$("#WithdrawAlert").hide();
		$("#WithdrawAlert").html("Please enter amount"); 			
		$("#WithdrawAlert").show();
		return false;
	}
	if(WithdrawCurrency==""){
		$("#WithdrawAlert").hide();
		$("#WithdrawAlert").html("Please select currency"); 			
		$("#WithdrawAlert").show();
		return false;}
	if(parseInt(WithdrawAmountFiat)<=parseInt(5)){
		$("#WithdrawAlert").hide();
		$("#WithdrawAlert").html("Amount should be greater than 5"); 			
		$("#WithdrawAlert").show();
		return false;}
}
function RejectReason(value){
	url = $("#RejectURL").attr('href');
	len = url.length-2;
	nurl = url.substr(0,len)+value;
	$("#RejectURL").attr('href',nurl);
}
function litecoinAddress(){
	address = $("#litecoinaddress").val();
  $("#SendLTCAddress").html(address); 	
	SuccessLTCButtonDisable();
	}
function SuccessLTCButtonDisable(){
	$("#SendLTCSuccessButton").attr("disabled", "disabled");
	}
function CheckLTCPayment(){
	$("#LTCAlert").hide();
	address = $("#litecoinaddress").val();
	if(address==""){
	$("#LTCAlert").html("Address incorrect"); 	
	$("#LTCAlert").show();
	return false;}
	amount = $("#Amount").val();
	if(amount==""){
	$("#LTCAlert").html("Not sufficient balance"); 	
	$("#LTCAlert").show();
	return false;}

	
	maxValue = $("#maxValue").val();
	if(parseFloat(amount)>parseFloat(maxValue)){
		$("#LTCAlert").html("Not sufficient balance"); 	
		$("#LTCAlert").show();
		return false;
		}
	$("#SendLTCFees").html($("#txFee").val());

	$("#SendLTCAmount").html(amount);	
	$("#SendLTCTotal").html(parseFloat(amount)-parseFloat($("#txFee").val()));	
	$("#TransferAmount").val(parseFloat(amount)-parseFloat($("#txFee").val()));

	$.getJSON('/Updates/LTCAddress/'+address,
		function(ReturnValues){
			if(ReturnValues['verify']['isvalid']==true){
			address = "<a href='http://ltc.block-explorer.com/address/"+ address +"' target='_blank'>"+ address +"</a> <i class='icon-ok'></i>";
			$("#SendLTCAddress").html(address); 	
			$("#SendLTCSuccessButton").removeAttr('disabled');				
				}
		});
	return true;
	}
	
function PaymentMethod(value){
	if(value=="bank"){
		$("#WithdrawalBank").show();
		$("#WithdrawalPost").hide();
	}
	if(value=="post"){
		$("#WithdrawalBank").hide();
		$("#WithdrawalPost").show();
	}
	
}