const app=()=>{(()=>{const e=document.querySelector("#fecha");e.addEventListener("input",(n=>{window.location="/admin?fecha="+e.value}))})()};document.addEventListener("DOMContentLoaded",(e=>{app()}));