<?php


//Para que funcione 

// Abre la carpeta de instalación de XAMPP en tu sistema.

// Dentro de la carpeta de XAMPP, busca la subcarpeta "php".

// Dentro de la carpeta "php", busca el archivo llamado "php.ini". Debes editar este archivo.

// Busca la línea que comienza con ";extension=ldap". Debes eliminar el punto y coma al principio de la línea para descomentarla, de manera que quede como "extension=ldap".

// Guarda los cambios en el archivo "php.ini" y ciérralo.

// Reinicia tu servidor web Apache a través del panel de control de XAMPP o mediante la línea de comandos.

class LDAP {
    private $ldapconn;
    private $server ;
    private $adminUser ;
    private $adminPassword ;

    public function __construct($server = "192.168.1.250", $adminUser = "PROTOTIPO\Administrator", $adminPassword = "Contrasena123") {
        $this->server = $server;
        $this->adminUser = $adminUser;
        $this->adminPassword = $adminPassword;
    }



// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ connect ------------
    public function connect() {
        $this->ldapconn = ldap_connect($this->server);

        if ($this->ldapconn) {
            $ldapbind = ldap_bind($this->ldapconn, $this->adminUser, $this->adminPassword);

            if ($ldapbind) {
                return true; // Conexión exitosa
            }
        } else {

            return false; // Conexión fallida
        }
        
    }
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ authenticateUser ------------
    public function authenticateUser($username, $password) {
        if (!$this->ldapconn) {
            return false; // No hay conexión LDAP
        }
    
        // Realiza la búsqueda del usuario en Active Directory
        $searchFilter = "(sAMAccountName=" . $username . ")";
        $search = ldap_search($this->ldapconn, "OU=staff,DC=Prototipo,DC=local", $searchFilter);
    
        if ($search) {
            $entry = ldap_get_entries($this->ldapconn, $search);
    
            if ($entry["count"] > 0) {
                // Intenta autenticar al usuario con la contraseña proporcionada
                $userDn = $entry[0]["distinguishedname"][0];
                $ldapbind = @ldap_bind($this->ldapconn, $userDn, $password);
    
                if ($ldapbind) {
                    // Autenticación exitosa, obtén datos adicionales del usuario
                    $userData = ldap_get_entries($this->ldapconn, $search);
                     //$firstName = $userData[0]["givenname"][0];
                     //$lastName = $userData[0]["sn"][0];
                  
    
                    return true;
                }
            }
        }
    
        return false; // Autenticación fallida
    }

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ authenticateUserSistemas ------------

    public function authenticateUserSistemas($username, $password) {

        try {
        if (!$this->ldapconn) {
            return false; // No hay conexión LDAP
        }
    
        // Realiza la búsqueda del usuario en Active Directory
        $searchFilter = "(sAMAccountName=" . $username . ")";
        $search = ldap_search($this->ldapconn, "OU=staff,DC=Prototipo,DC=local", $searchFilter);
    
        if ($search) {
            $entry = ldap_get_entries($this->ldapconn, $search);
    
            if ($entry["count"] > 0) {
                // Intenta autenticar al usuario con la contraseña proporcionada
                $userDn = $entry[0]["distinguishedname"][0];
                $ldapbind = @ldap_bind($this->ldapconn, $userDn, $password);
    
                if ($ldapbind) {
                    // Autenticación exitosa, ahora verifica la pertenencia al grupo "TicketeraAccess"
                    $groupSearchFilter = "(member=" . $userDn . ")";
                    $groupSearch = ldap_search($this->ldapconn, "CN=TicketeraAccess,OU=staff,DC=Prototipo,DC=local", $groupSearchFilter);
    
                    if (ldap_count_entries($this->ldapconn, $groupSearch) > 0) {
                        // El usuario pertenece al grupo "TicketeraAccess"
                        $userData = ldap_get_entries($this->ldapconn, $search);
                        // $firstName = $userData[0]["givenname"][0];
                        // $lastName = $userData[0]["sn"][0];
                       
    
                        return true;
                    }
                }
            }
        }
    
        return false; // Autenticación fallida o no es miembro del grupo

    } catch (Exception $e) {
        // Maneja la excepción, por ejemplo, muestra un mensaje de error
        echo "Error LDAP: " . $e->getMessage();
    }
    }
    
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getUserInfo ------------

    public function getUserInfo($username) {
        // Realiza la búsqueda del usuario en Active Directory
        $searchFilter = "(sAMAccountName=" . $username . ")";
        $search = ldap_search($this->ldapconn, "OU=staff,DC=Prototipo,DC=local", $searchFilter);
    
        if ($search) {
            $entry = ldap_get_entries($this->ldapconn, $search);
    
            if ($entry["count"] > 0) {
                // Obtiene el nombre de usuario, nombre y apellido del usuario
                $userInfo = array(
                    'usuario' => $entry[0]["samaccountname"][0],
                    'nombre' => $entry[0]["givenname"][0],
                    'apellido' => $entry[0]["sn"][0]
                );
    
                return $userInfo;
            }
        }
    
        return false; // No se pudo obtener la información del usuario
    }
    


// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ authenticateUserSistemas ------------

public function authenticateUserSupervision($username, $password) {

    try {
    if (!$this->ldapconn) {
        return false; // No hay conexión LDAP
    }

    // Realiza la búsqueda del usuario en Active Directory
    $searchFilter = "(sAMAccountName=" . $username . ")";
    $search = ldap_search($this->ldapconn, "OU=staff,DC=Prototipo,DC=local", $searchFilter);

    if ($search) {
        $entry = ldap_get_entries($this->ldapconn, $search);

        if ($entry["count"] > 0) {
            // Intenta autenticar al usuario con la contraseña proporcionada
            $userDn = $entry[0]["distinguishedname"][0];
            $ldapbind = @ldap_bind($this->ldapconn, $userDn, $password);

            if ($ldapbind) {
                // Autenticación exitosa, ahora verifica la pertenencia al grupo "TicketeraAccessSuper"
                $groupSearchFilter = "(member=" . $userDn . ")";
                $groupSearch = ldap_search($this->ldapconn, "CN=TicketeraAccessSuper,OU=staff,DC=Prototipo,DC=local", $groupSearchFilter);

                if (ldap_count_entries($this->ldapconn, $groupSearch) > 0) {
                    // El usuario pertenece al grupo "TicketeraAccess"
                    $userData = ldap_get_entries($this->ldapconn, $search);
                    // $firstName = $userData[0]["givenname"][0];
                    // $lastName = $userData[0]["sn"][0];
                   

                    return true;
                }
            }
        }
    }

    return false; // Autenticación fallida o no es miembro del grupo

} catch (Exception $e) {
   
    echo "Error LDAP: " . $e->getMessage();
}
}
}  