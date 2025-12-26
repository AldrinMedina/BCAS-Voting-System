

<style>


main#main {
    width: 100%;
    height: 100%;
    background: white;
    }

    #login-left {
        position: fixed;
        left: 0;
        width: 60%;
        height: 100%;
        background: #f5f5f5; 
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        border-radius: 10px;
    }

    #login-left .logo {
        text-align: center;
    }

    #login-left .logo h1 {
        font-size: 3rem;
        color: #333;
        margin: 0;
    }

    #login-left .logo img {
        max-width: 100%;
        height: auto;
        margin-top: 20px;
    }

    #login-right {
        position: fixed;
        right: 0;
        width: 40%;
        height: 100%;
        background: limegreen;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #login-right .card {
        width: 90%;
        max-width: 400px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }

    .form-control {
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        padding: 15px;
    }

    .btn-primary {
        background: #007bff;
        border-color: #007bff;
    }

    .callout {
        padding: 10px;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 4px;
        color: #721c24;
    }
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins" , sans-serif;
    }
    body{
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-image:url(images/2.jpg);
      background-repeat: no-repeat;
      background-size:cover;
      padding: 30px;
    }
    .container{
      position: relative;
      max-width: 1000px;
      width: 100%;
      background: white;
      padding: 60px 80px;
      box-shadow: 0 5px 10px rgba(0,0,0,0.2);
      perspective: 2700px;
      height: 700px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .container .cover{
      position: absolute;
      top: 0;
      left: 50%;
      height: 100%;
      width: 50%;
      z-index: 98;
      transition: all 1s ease;
      transform-origin: left;
      transform-style: preserve-3d;
    }
    .container #flip:checked ~ .cover{
      transform: rotateY(-180deg);
    }
    .container .cover .front,
    .container .cover .back{
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
    }
    .cover .back{
      transform: rotateY(180deg);
      backface-visibility: hidden;
    }
    .container .cover::before,
    .container .cover::after{
      content: '';
      position: absolute;
      height: 100%;
      width: 100%;
      
      opacity: 0.5;
      z-index: 12;
    }
    .container .cover::after{
      opacity: 0.3;
      transform: rotateY(180deg);
      backface-visibility: hidden;
    }
    .container .cover img{
      position: absolute;
      height: 500px;
      width: 500px;
      object-fit: cover;
      z-index: 10;
    }
    .container .cover .text{
      position: absolute;
      z-index: 130;
      height: 100%;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .cover .text .text-1,
    .cover .text .text-2{
      font-size: 26px;
      font-weight: 600;
      color: #fff;
      text-align: center;
    }
    .cover .text .text-2{
      font-size: 15px;
      font-weight: 500;
    }
    .container .forms{
      height: 100%;
      width: 100%;
      background: #fff;
    }
    .container .form-content{
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .form-content .login-form,
    .form-content .signup-form{
      width: calc(100% / 2 - 25px);
    }
    .forms .form-content .title{
      position: relative;
      font-size: 24px;
      font-weight: 500;
      color: #333;
    }
    .forms .form-content .title:before{
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      height: 3px;
      width: 25px;
      background: #aeadaf;
    }
    .forms .signup-form  .title:before{
      width: 20px;
    }
    .forms .form-content .input-boxes{
      margin-top: 30px;
    }
    .forms .form-content .input-box{
      display: flex;
      align-items: center;
      height: 50px;
      width: 100%;
      margin: 10px 0;
      position: relative;
    }
    .form-content .input-box input{
      height: 100%;
      width: 100%;
      outline: none;
      border: none;
      padding: 0 30px;
      font-size: 16px;
      font-weight: 500;
      border-bottom: 2px solid rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }
    .form-content .input-box input:focus,
    .form-content .input-box input:valid{
      border-color: #7d2ae8;
    }
    .form-content .input-box i{
      position: absolute;
      color: #7d2ae8;
      font-size: 17px;
    }
    .forms .form-content .text{
      font-size: 14px;
      font-weight: 500;
      color: #333;
    }
    .forms .form-content .text a{
      text-decoration: none;
    }
    .forms .form-content .text a:hover{
      text-decoration: underline;
    }
    .forms .form-content .button{
      color: #fff;
      margin-top: 40px;
    }
    .forms .form-content .button input{
      color: #fff;
      background: #8142c1;
      border-radius: 6px;
      padding: 0;
      cursor: pointer;
      transition: all 0.4s ease;
    }
    .forms .form-content .button input:hover{
      background: #5b13b9;
    }
    .forms .form-content label{
      color: #5b13b9;
      cursor: pointer;
    }
    .forms .form-content label:hover{
      text-decoration: underline;
    }
    .forms .form-content .login-text,
    .forms .form-content .sign-up-text{
      text-align: center;
      margin-top: 25px;
    }
    .container #flip{
      display: none;
    }
    @media (max-width: 730px) {
      .container .cover{
        display: none;
      }
      .form-content .login-form,
      .form-content .signup-form{
        width: 100%;
      }
      .form-content .signup-form{
        display: none;
      }
      .container #flip:checked ~ .forms .signup-form{
        display: block;
      }
      .container #flip:checked ~ .forms .login-form{
        display: none;
      }
    }

</style>

