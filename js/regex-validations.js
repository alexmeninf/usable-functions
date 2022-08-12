// Verificar alguma letra maiúscula
const regexMaiuscula = /[A-Z]/; 
// Verificar algum número
const regexNumeros = /[0-9]/; 
// Verificar algum caractere especial
const regexCaracterEspecial = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/; 


isMobile = () => /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
isAndroid = () => /Android/i.test(navigator.userAgent);
isApple = () => /iPhone|iPad|iPod/i.test(navigator.userAgent);
