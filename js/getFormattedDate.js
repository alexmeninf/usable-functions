  getCurrentDate = () => {
    let currentDate = new Date();

    // Adiciona o digito 0
    let month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
    let date = ("0" + currentDate.getDate()).slice(-2);
    let hour = ("0" + currentDate.getHours()).slice(-2);
    let minutes = ("0" + currentDate.getMinutes()).slice(-2);
    let seconds = ("0" + currentDate.getSeconds()).slice(-2);

    let formatDate = month + '-' + date + '-' + currentDate.getFullYear() + '%20' + hour + ':' + minutes + ':' + seconds;

    return formatDate.toLocaleString("pt-BR", {
      timeZone: "America/Sao_Paulo"
    });
  }
