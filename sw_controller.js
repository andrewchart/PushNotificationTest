//console.log("Hello sw_controller.js");

//Check for serviceworker and register it
if ('serviceWorker' in navigator) {

	//console.log("Browser is service worker compatible");
	
	navigator.serviceWorker.register("sw.js").then(function(reg){
	
		console.log("Serviceworker Registered");
		
		//PUSH: Assume unsubscribed
		var isSubscribed = false;
		var subscribeBtn = document.getElementById('subscribeToggle');
		
		//Get subscription status
		function getSubscriptionObject() {
			//?????
		}
		
		//Subscribe to push function
		function registerForPush() {
			
			reg.pushManager.subscribe({
				userVisibleOnly: true
			}).then(function(pushSubscription){
				console.log('Endpoint: ', pushSubscription.endpoint);
				isSubscribed = true;
				subscribeBtn.textContent = "Unsubscribe from notifications";
			}).catch(function(error) {
			    console.log('Error subscribing', error);
			    subscribeBtn.textContent = 'Register for notifications';
			});;
			
		}
		
		//Unsubscribe function
		function unsubscribeFromPush(){
			alert("unsub");
			getSubscriptionObject();
			pushSubscription.unsubscribe().then(function(event) {
			    subscribeBtn.textContent = 'Register for notifications';
			    console.log('Unsubscribed!', event);
			    isSubscribed = false;
			}).catch(function(error) {
			    console.log('Error unsubscribing', error);
			    subscribeBtn.textContent = 'Unsubscribe from notifications';
			});	
		}
		
		//Button handler
		function subscribeToggle() {
			if(isSubscribed) {
				unsubscribeFromPush();
			} else {
				registerForPush();
			}
		}
		subscribeBtn.addEventListener('click',subscribeToggle);
		
		
		
		
		//Check for permissions or ask for them
		/*if(localStorage.getItem("pushSub") == "true") {
			console.log("Push Permission Previously Granted");
			registerForPush();
		} 
		
		else if(confirm("We'd like to send to send you push notifications")) {
			console.log("Push Permission Granted by Confirm");
			localStorage.setItem("pushSub", true);
			registerForPush();			
		}
		
		
		//Set Button States
		if(localStorage.getItem("pushSub") == "true") {
			document.getElementById('register').classList.add("inactive");
		} else {
			document.getElementById('unregister').classList.add("inactive");
		}*/
	
	
	}).catch(function(err){
		console.log(err);
	});
	
}



//Push notification sub/unsub click handlers
/*document.getElementById('register').addEventListener('click', function(){
	this.classList.add("inactive");
	document.getElementById('unregister').classList.remove("inactive");
	localStorage.setItem("pushSub", "true");
});

document.getElementById('unregister').addEventListener('click', function(){
	this.classList.add("inactive");
	document.getElementById('register').classList.remove("inactive");
	localStorage.setItem("pushSub", "false");
});*/