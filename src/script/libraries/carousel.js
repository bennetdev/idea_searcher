class Carousel{
    constructor(prev, next, content) {
        this.prevSel = prev;
        this.nextSel = next;
        this.contentSel = content;
        this.moveTo = 0;
        this.setup();
    }
    setup(){
        console.log(this.moveTo)
        var content = document.querySelector(this.contentSel)
        this.moveTo = content.clientWidth;
    }
    next(){
        var content = document.querySelector(this.contentSel)
        var currentMargin = parseInt(content.style.marginLeft.slice(0, -2));
        if (isNaN(currentMargin)) {
            currentMargin = 0
        }
        console.log(this.moveTo, currentMargin)
        if(this.moveTo + currentMargin > 0){
            content.style.marginLeft = (currentMargin - this.moveTo).toString() + "px";
        }
    }
    prev(){
        var content = document.querySelector(this.contentSel)
        var currentMargin = parseInt(content.style.marginLeft.slice(0, -2));
        if (isNaN(currentMargin)) {
            currentMargin = 0
        }
        if(currentMargin < 0){
            content.style.marginLeft = (currentMargin + this.moveTo).toString() + "px";
        }
    }
}