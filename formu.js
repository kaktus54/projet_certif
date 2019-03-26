
    /*fonction validation*/

        function verifyInput(nom, hasError) {
            var nom = document.getElementById(nom);
            if(nom.value === "") {
                hasError = true;
                nom.classList.add("incorrect");
            }
            return hasError;
        }


    /*fonction caractéres mdp*/

    function CheckForm()
    {
        var pwd = document.getElementById("pwd1").value;
        var listRe = [{
            re: /[a-z A-Z \d]/g,
            count: 8,
            msg: "Votre mot de passe doit avoir au moins 8 caractères dont 1 chiffre et 1 majuscule"
        }, {
            re: /\d/g,
            count: 1,
            msg: "Votre mot de passe doit avoir au moins 1 chiffre"
        }, {
            re: /[A-Z]/g,
            count: 1,
            msg: "Votre mot de passe doit posséder au moins 1 majuscule"
        }];

        for (var i = 0; i < listRe.length; i++) {
            var item = listRe[i];
            var match = pwd.match(item.re);
            if (null === match || match.length < item.count) {
                alert(item.msg);
                return false;
            }
        }
    }


    /*fonction 1=2 mdp*/

    function mdpconfirmation() {

        var pwd1 = document.getElementById('pwd1').value;
        var pwd2 = document.getElementById('pwd2').value ;
        if (pwd1 === pwd2) {
            return false;
        } else {
            alert('mot de passe non identique');
            return true;
        }

    };

    /*fonction 1=2 mail*/

    function mailconfirmation() 
    {
        var mail = document.getElementById('mail').value;
        var mailconf = document.getElementById('mailconf').value;
        if (mail === mailconf) {
            return false;
        } else {
        alert('adresse mail non identique');
            return true;
        }

    };

    function setRoute($nameTag, $eventName, $route) {
        if(document.getElementById($nameTag) !== null) {
            document.getElementById($nameTag).addEventListener($eventName, function(e) {
                e.preventDefault();
                document.getElementById('routage').value = $route;
                $('#mainForm').submit();
            });
        }
    }
    setRoute('btnConnection', 'click', 'connection');
    setRoute('btnformulaire', 'click', 'formulaire');
    setRoute('btnvalideConnection', 'click', 'valideConnection');
    setRoute('btnenvoiPhoto', 'click', 'envoiphoto');
    setRoute('btnmodification', 'click', 'modification');
    setRoute('btnretourgalerie', 'click', 'retourgalerie');
    setRoute('btnValidePhoto', 'click', 'envoiphoto');
    setRoute('btnRenvoieMdp', 'click', 'renvoieMdp');
    
    setRoute('btnquit', 'click', 'quit');

    




/*valisation formulaire */

    var button = document.getElementById('btnInscription');
    if(button !== null) {
        button.addEventListener('click', function(e) {
            var hasError = false;
            hasError = verifyInput("lastName", hasError);
            hasError = verifyInput("firstName", hasError);
            hasError = verifyInput("mail", hasError);
            hasError = verifyInput("mailconf", hasError);
            hasError = verifyInput("login", hasError);
            hasError = verifyInput("pwd1", hasError);
            hasError = verifyInput("pwd2", hasError);
            CheckForm();
            hasError = mailconfirmation();
            hasError = mdpconfirmation();
            var checkBox = document.getElementById("check");
            if(!checkBox.checked) {
                hasError = true;
                checkBox.classList.add("incorrect1");
            } 
            if(!hasError) {
                setRoute('btnInscription', 'click', 'addUser');
            }
        });
    }
    
    var button = document.getElementById('btnModif');
    if(button !== null) {
        button.addEventListener('click', function(e) {
            var hasError = false;
            hasError = verifyInput("lastName", hasError);
            hasError = verifyInput("firstName", hasError);
            hasError = verifyInput("mail", hasError);
            hasError = verifyInput("mailconf", hasError);
            hasError = verifyInput("login", hasError);
            hasError = verifyInput("pwd1", hasError);
            hasError = verifyInput("pwd2", hasError);
            CheckForm();
            hasError = mailconfirmation();
            hasError = mdpconfirmation();
            var checkBox = document.getElementById("check");
            if(!checkBox.checked) {
                hasError = true;
                checkBox.classList.add("incorrect1");
            } 
            if(!hasError) {
                setRoute('btnModif', 'click', 'changUser');
            }
        });
    }

function twPopConstructeur(){
    var anchors = document.getElementsByTagName("a");
    for (var i=0; i<anchors.length; i++){
        var anchor = anchors[i];
        var relAttribute = String(anchor.getAttribute("class"));
        if (anchor.getAttribute("href") && (relAttribute.toLowerCase().match("twpop"))){
            var oParent = anchor.parentNode;
            var oImage=document.createElement("img");
            oImage.src = anchor.getAttribute("href");
            oImage.alt = anchor.getAttribute("title")
             
            var oLien=document.createElement("a");
            oLien.href = "#ferme";
            oLien.title = anchor.getAttribute("title");
            oLien.onclick = "return false;";
            oLien.appendChild(oImage);
             
            var sNumero = "id"+i;
             
            var node=document.createElement("div");
            node.id = sNumero;
            node.className = "twAudessus";
            node.appendChild(oLien);
            anchor.setAttribute("href","#"+sNumero);
      oParent.appendChild(node);
        }
    }
}




