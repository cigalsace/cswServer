# cswServer

Application PHP permettant de simuler un server CSW à partir d'un dossier contenant des fichiers XML conforment à la directive européenne Inspire.
cswServer permet un moissonnage de fichiers XML par Geonetwork (v. 2.10 testée).


## Technologie:

cswServer est développé en PHP.


## Principes

cswServer simule les requêtes de base "GetCapabilities", "DescribeRecord", "GetRecords" et "GetRecordById" à partir de fichiers XML stockés dans des répertoires sur le serveur.  
Il est possible de configurer plusieurs noeuds ("nodes") ou points de moissonnage.  
Chaque noeud:
- correspond à un dossier contenant des fichiers XML inclu dans le répertoire "nodes".
- est configuré dans un fichier PHP contenu dans le dossier "csw". 


## Installation et utlisation

1. Copier les fichiers sur le serveur.
2. Dans le dossier "nodes", créer les dossiers correspondant aux noeuds ou points de moissonnage souhaités et copier les fichiers XML dans chaque noeuds. Les fichiers peuvent être organisés selon une arborescence.
3. Dans le dossier "csw", créer 1 fichier php par noeud à partir de "node.php" et adapter la configuration, notamment pour les informations apparaissant dans les capacités du serveur (GetCapabilities).


## Exemple
 
Je souhaite créer un noeud appelé "super-node":
- Je crée un dossier "super-node" dans le répertoire "nodes" et j'y copie mes fichiers XML.
- Je copie le fichier "nodes.php" dans le répertoire "csw" et le renomme en "super-nodes.php".
- Je configure les informations de mon fichier "super-node.php"


## Démonstration

GetCapabilities: http://cigalsace.net/cswServer/0.01/csw/node.php?VERSION=2.0.2&SERVICE=CSW&REQUEST=getcapabilities

GetRecords: http://cigalsace.net/cswServer/0.01/csw/node.php?request=getrecords&maxrecords=20&startposition=1

GetRecordById: http://cigalsace.net/cswServer/0.01/csw/node.php?request=getrecordbyid&id=FR-236700019-2007-SPOT5-CIGAL_test


## Versions

### 0.7.1

- Bug: si le dossier contient des XML qui ne sont pas des fiches de métadonnées, elles ne sont pas affichées, mais restent contabilisées dans le nombre de résultats retournés. 
- Bug: correction de l'affichage des résultats lors d'une recherche (une fiche manquante).
- Bug: la recherche AnyText ne renvoit pas le bon nombre de fiches en retour (si une fiche contient le mot recherché plus d'une fois elle n'est pas retournée).

### 0.7.0

- Renommage des versions: la version 0.07 devient la 0.7.0.
- Bug: l'infinite scroll ne fonctionne pas dans cswReaderJS car erreur dans le calcul du nombre de résultats retournés.




