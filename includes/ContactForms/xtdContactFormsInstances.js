/* 
	Flexi ContactForms error messages

	Modify the messages bellow if you want to customize the error messages thrown by your contact forms. 

*/
var xtdContactFormsMessages = { 
	"email" 	: "Email value is not correct.", // The error will appear when Email field is required but is not filled out	

	"website" 	: "Website value is not correct.", // The error will appear when Website field is required but is not filled out

	"phone"	    : "Phone value is not correct.", // The error will appear when Phone field is required but is not filled out	

	"code"		: "Postal code must be just numbers.", // The error will appear when ZIP/Postal Code field contains anything but numbers

	"numberbox" : "Number Box must be just numbers.", // The error will appear when Number Box field contains anything but numbers

	"captcha"   : "Captcha value is not correct.", // The error will appear when Captcha field is required but is not filled out	

	"phperror"  : "There was a problem sending your message. Please try again.", // The error will appear when PHP script fails

	"required"	: "This value is required" // The error will appear when a value is not typed in input field
};





/**
	Flexi ContactForms initialization	
*/

(function($) {
   
	if(!window.xtdContactFormsMessages){
        xtdContactFormsMessages = xtdDefaultContactFormsMessages;
    }

    $(document).ready(function(){

// ContactForm start

$('.ContactForms1').xtdContactForm({ 
 	"emailSent" : "firstOption", 
 	"relPath" : "", 
 	"emailSentMessage" : "Your%20message%20was%20sent%20successfully!%0D%0DPlease%20expect%20a%20responce%20either%20by%20Phone%20or%20by%20email%20in%20the%20next%201-2%20days"
 });

$('.ContactForms2').xtdContactForm({ 
 	"emailSent" : "firstOption", 
 	"relPath" : "", 
 	"emailSentMessage" : "Your%20message%20was%20sent%20successfully!%0D%0DPlease%20expect%20a%20responce%20within%20two%20days.%0D%0DIf%20contact%20is%20needed%20immediately%20please%20call%20at%20%2B1%20(203)%20970-2268"
 });

$('.ContactForms3').xtdContactForm({"emailSent":"firstOption","relPath":"","emailSentMessage":"Your%20message%20was%20sent%20successfully!%0D%0DIf%20immediate%20contact%20is%20needed%20please%20call%20%2B1%20(203)%20970-2268."});
// ContactForm end 

    });


}(menus_jQuery));