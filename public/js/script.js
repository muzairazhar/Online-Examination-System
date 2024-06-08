var signupbtn=document.querySelector('.signupbtn');
var siginbtn=document.querySelector('.signinbtn');
var namefield=document.querySelector('.namefield');
var title=document.querySelector('.title');
var underline=document.querySelector('.underline');
var text=document.querySelector('.text');

siginbtn.addEventListener('click',function(){
namefield.style.maxHeight='0';
title.innerHTML="Sign In";
text.innerHTML="Lost Password"
signupbtn.classList.add('disable');
siginbtn.classList.remove('disable');
underline.style.transform='translatex(35px)';
});

signupbtn.addEventListener('click',function(){
    namefield.style.maxHeight='60px';
    title.innerHTML="Sign up";
    text.innerHTML="Password Suggestions"
    signupbtn.classList.remove('disable');
    siginbtn.classList.add('disable');
    underline.style.transform='translatex(0)';
    });