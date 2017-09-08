var timesssout;
function VerticalScroll(content, btnPrevious, btnNext, autoStart) {
  this.Delay = 10;
  this.LineHeight = 20;
  this.Amount = 1; //ע��:LineHeightһ��Ҫ������Amount.
  this.Direction = "up";
  if(timesssout>0){
  	this.Timeout = timesssout*1000;
  }else{
	  this.Timeout = 4000;
	}
  this.ScrollContent = this.$(content);
  this.ScrollContent.innerHTML += this.ScrollContent.innerHTML;
  //this.ScrollContent.scrollTop = 0;
  if (btnNext) {
    this.NextButton = this.$(btnNext);
    this.NextButton.onclick = this.GetFunction(this, "Next");
    this.NextButton.onmouseover = this.GetFunction(this, "Stop");
    this.NextButton.onmouseout = this.GetFunction(this, "Start");
  }
  if (btnPrevious) {
    this.PreviousButton = this.$(btnPrevious);
    this.PreviousButton.onclick = this.GetFunction(this, "Previous");
    this.PreviousButton.onmouseover = this.GetFunction(this, "Stop");
    this.PreviousButton.onmouseout = this.GetFunction(this, "Start");
  }
  this.ScrollContent.onmouseover = this.GetFunction(this, "Stop");
  this.ScrollContent.onmouseout = this.GetFunction(this, "Start");
  if (autoStart) {
    this.Start();
  }
}

VerticalScroll.prototype.$ = function(element) {
  return document.getElementById(element);
}

VerticalScroll.prototype.Previous = function() {
  clearTimeout(this.AutoScrollTimer);
  clearTimeout(this.ScrollTimer);
  this.Scroll("up");
}

VerticalScroll.prototype.Next = function() {
  clearTimeout(this.AutoScrollTimer);
  clearTimeout(this.ScrollTimer);
  this.Scroll("down");
}

VerticalScroll.prototype.Start = function() {
  clearTimeout(this.AutoScrollTimer);
  this.AutoScrollTimer = setTimeout(this.GetFunction(this, "AutoScroll"), this.Timeout);
}

VerticalScroll.prototype.Stop = function() {
  clearTimeout(this.ScrollTimer);
  clearTimeout(this.AutoScrollTimer);
}

VerticalScroll.prototype.AutoScroll = function() {
  if (this.Direction == "up") {
    if (parseInt(this.ScrollContent.scrollTop) >= parseInt(this.ScrollContent.scrollHeight) / 2) {
      this.ScrollContent.scrollTop = 0;
    }
    this.ScrollContent.scrollTop += this.Amount;
  } else {
    if (parseInt(this.ScrollContent.scrollTop) <= 0) {
      this.ScrollContent.scrollTop = parseInt(this.ScrollContent.scrollHeight) / 2;
    }
    this.ScrollContent.scrollTop -= this.Amount;
  }
  if (parseInt(this.ScrollContent.scrollTop) % this.LineHeight != 0) {
    this.ScrollTimer = setTimeout(this.GetFunction(this, "AutoScroll"), this.Delay);
  } else {
    this.AutoScrollTimer = setTimeout(this.GetFunction(this, "AutoScroll"), this.Timeout);
  }
}

VerticalScroll.prototype.Scroll = function(direction) {
  if (direction == "up") {
    if (this.ScrollContent.scrollTop == 0) {
      this.ScrollContent.scrollTop = parseInt(this.ScrollContent.scrollHeight) / 2;
    }
    this.ScrollContent.scrollTop -= this.Amount;
  } else {
    this.ScrollContent.scrollTop += this.Amount;
  }
  if (parseInt(this.ScrollContent.scrollTop) >= parseInt(this.ScrollContent.scrollHeight) / 2) {
    this.ScrollContent.scrollTop = 0;
  }
  if (parseInt(this.ScrollContent.scrollTop) % this.LineHeight != 0) {
    this.ScrollTimer = setTimeout(this.GetFunction(this, "Scroll", direction), this.Delay);
  }
}

VerticalScroll.prototype.GetFunction = function(variable, method, param) {
  return function() {
    variable[method](param);
  }
}