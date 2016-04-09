# cswServer

Application PHP permettant de simuler un server CSW à partir d'un dossier contenant des fichiers XML conforment à la directive européenne Inspire.
cswServer permet un moissonnage de fichiers XML par Geonetwork (v. 2.10 testée).


## Technologie:

cswServer est développé en PHP.


## Principes:

cswServer simule les requêtes de base "GetCapabilities", "DescribeRecord", "GetRecords" et "GetRecordById" à partir de fichiers XML stockés dans des répertoires sur le serveur.
Il est possible de configurer plusieurs noeuds ("nodes") ou points de moissonnage.
Chaque noeud:
- est configuré dans un fichier PHP contenu dans le dossier "csw".
- correspond à un point d'accès à un ensemble de fichiers XML inclu dans le répertoire "nodes".


## Installation et utlisation

1. Copier les fichiers sur le serveur.
2. Dans le dossier "nodes", créer l'arborescence que vous souhaitez pour stocker les fichers XML. Généralement un dossier correspond à un noeud, mais l'application peut également parcourir récursivement les différents répertoires. Copier les fichiers XML dans les dossiers.
3. Dans le dossier "csw", créer 1 fichier php par noeud à partir de "node.php" et adapter la configuration, notamment pour les informations apparaissant dans les capacités du serveur (GetCapabilities).


## Cas d'usage

**Je souhaite créer un noeud "super-node" pour diffuser les fichiers XML contenus dans un dossier**
- Je crée un dossier "super-node" dans le répertoire "nodes" et j'y copie mes fichiers XML.
- Je copie le fichier "nodes.php" dans le répertoire "csw" et le renomme en "super-nodes.php".
- Je configure les informations de mon fichier "super-node.php" en pointant ``$csw_path`` vers le répertoire "super-node"

**Je souhaite créer un noeud "super-node" pour diffuser les fichiers contenu dans une arborescence de dossier**
- Je crée un dossier "super-node" dans le répertoire "nodes" et l'arborescence des sous dossiers nécessaires.
- Je copie les fichiers XML dans mon arborescence.
- Je copie le fichier "nodes.php" dans le répertoire "csw" et le renomme en "super-nodes.php".
- Je configure les informations de mon fichier "super-node.php" en pointant ``$csw_path`` vers le répertoire "super-node" (l'application lit récursivement les sous dossiers de l'arborescence)

**Je souhaite créer un noeud "super-node" pour diffuser les fichiers contenu dans une arborescence de dossier en filtrant les fiches selon le mot-clé "données ouvertes"**
- Je crée un dossier "super-node" dans le répertoire "nodes" et l'arborescence des sous dossiers nécessaires.
- Je copie les fichiers XML dans mon arborescence.
- Je copie le fichier "nodes.php" dans le répertoire "csw" et le renomme en "super-nodes.php".
- Je configure les informations de mon fichier "super-node.php" en pointant ``$csw_path`` vers le répertoire "super-node" (l'application lit récursivement les sous dossiers de l'arborescence) et en paramétrant ``$constraintKeywords = "données ouvertes".


## Démonstration:

GetCapabilities: http://cigalsace.net/cswServer/0.03/csw/node.php?VERSION=2.0.2&SERVICE=CSW&REQUEST=getcapabilities

GetRecords: http://cigalsace.net/cswServer/0.03/csw/node.php?request=getrecords&maxrecords=20&startposition=1

GetRecordById: http://cigalsace.net/cswServer/0.03/csw/node.php?request=getrecordbyid&id=FR-236700019-2007-SPOT5-CIGAL_test
