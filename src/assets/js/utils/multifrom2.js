
const steps = document.querySelectorAll('.form-step');
const nextBtns = document.querySelectorAll('.next');
const prevBtns = document.querySelectorAll(".prev");
const progressSteps = document.querySelectorAll('.step');
const progressBar = document.querySelector('.progress');

let formStep = 0;

function updateForm(){
    steps.forEach((step, i)=> step.classList.toggle("active", i == formStep));

    progressSteps.forEach((s,i)=>{
        s.classList.toggle("active", i <= formStep);
    });

    const progressPercent = (formStep / (progressSteps.length -1)) * 100;
    progressBar.style.width = progressPercent + "%";
}

nextBtns.forEach((btn)=>{
    btn.addEventListener("click", ()=>{
        formStep++;
        if (formStep > steps.length - 1) formStep = steps.length -1;
        updateForm();
    });
});

prevBtns.forEach((btn)=>{
    btn.addEventListener("click", ()=>{
        formStep--;
        if (formStep < 0) formStep = 0;
        updateForm();
    });
});

updateForm();

$(".f1").hide().slideDown(600); // Efecto de aparición en 600ms
