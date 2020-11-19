(*
 ------------------------------------------------------------------------------------
 -- Fichier           : unitprojet
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 18/05/18
 --
 -- But               :
 -- Remarques         : ras
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Unit Unitprojet;

interface
Uses UnitType,Unitafficheprojet;
   

   
Function choixPiece(main :ptr_piece; p:Integer):piece;
Function SuppDeb(l : ptr_piece):ptr_piece;
Function ajoutfin(l : ptr_piece;couleurs,formes:integer):ptr_piece;
Function SuppVal(l : ptr_piece;couleurs,formes:integer):ptr_piece;
Function remplace(main,pioche : ptr_piece; p:integer):typeMain;
Function jouerPieceMain(main : ptr_piece; p:Integer):typeMain;
Function placementPiece(Grille : typeGrille;couleurs,formes,ligne,colone:integer):typeGrille;
Function verification(grille : typeGrille;couleurs,formes,ligne,colone:integer ):Boolean;
Function compte(grille : typeGrille;tab:array of integer;g,compteur:integer):Integer;
Function doublons(l : ptr_piece):ptr_piece;
Function nbElements(main : ptr_piece):Integer;
Function demandejoueur(pioche:ptr_piece):typejoueurs;
Function compareage(age1,age2 : Integer):Integer;
Function creerordre(nb :Integer; pioche:ptr_piece):senstour;
Function placementdsgrille(grille : typegrille;piece:piece;l,c:integer):typegrille;
Function mainvide(tour :  senstour):Boolean;
Function finjeu(pioche : ptr_piece;tour:senstour):boolean;
Function premierplacement(grille : typeGrille;couleurs,formes:integer;taille:integer):typeGrille;
Function maxpoints(tour	: senstour):typejoueurs;


implementation


(*==================================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : choixPiece
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : choisi une piece dans la main d'un joueur
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)     
Function choixPiece(main :ptr_piece; p:Integer):piece;
VAR
   i   : Integer;
   res : piece;
   tmp : ptr_piece;
   
Begin
   res.suivant:=main;
   tmp:=main;
   For i:=0 to p-1 do
   Begin
       tmp:=tmp^.suivant;
   End; 
   res.couleurs:=tmp^.couleurs;
   res.formes:=tmp^.formes;
   choixPiece:=res;
End;

(*==============================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : SuppDeb
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : suprime le premiere valeur d'une liste
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)

Function SuppDeb(l : ptr_piece):ptr_piece;
Var
   n : ptr_piece;
BEGIN
   n := NIL;
   if (l<>NIL) then
      begin
	 n := l^.suivant;
	 dispose(l);
      end;
   SuppDeb := n;
END;

(*==============================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : ajoutFin
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : ajoute une valeur a la fin de la liste
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function ajoutfin(l : ptr_piece;couleurs,formes:integer):ptr_piece;
VAR
   tmp : ptr_piece;
BEGIN
   if (l=NIL) then
   Begin
      ajoutfin := creerPiece(couleurs,formes);
   End
   ELse
   Begin
      if (l^.suivant<>Nil) then
      Begin
	 l^.suivant := ajoutfin(l^.suivant,couleurs,formes);
	 ajoutfin := l;
      End
      else
      begin
	 tmp:=creerPiece(couleurs,formes);
	 l^.suivant:=tmp;
	 ajoutfin:=l;
      end;
   End;
END;

(*============================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : SuppVal
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : suprime une certaine piece dans la liste
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function SuppVal(l : ptr_piece;couleurs,formes:integer):ptr_piece;
VAR
   n : ptr_piece;
BEGIN
   if (l=NIL) then
   begin
      SuppVal:=l;
   end
   else
   begin
      if (l^.couleurs=couleurs) and (l^.formes=formes) then
      begin
	 n:=l^.suivant;
	 dispose(l);
	 SuppVal:=n;
      End
   else
   begin
      l^.suivant:=SuppVal(l^.suivant,couleurs,formes);
      SuppVal:=l;
   end;
   End;
END;

(*=========================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : remplace
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : remplace une piece dans la main par la premiere de la pioche
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)

Function taillepioche(l :ptr_piece):Integer;
VAR
   res : Integer;

Begin
   res:=0;
   While (l<>NIl) do
   Begin
      l:=l^.suivant;
      res:=res+1;
   End;
   taillepioche:=res;
End;

Function remplace(main,pioche : ptr_piece; p:integer):typeMain;
Var
   choix		: piece;
   piocheN,mainN,piece1	: ptr_piece;
   res			: typeMain;
   q			: integer;
   nbpioche		: Integer;
BEGIN
   choix:=choixPiece(main,p);
   piece1:=creerPiece(pioche^.couleurs,pioche^.formes);
   piocheN:=SuppDeb(pioche);
   nbpioche:=taillepioche(piocheN);
   q:=random(nbpioche);
   piocheN:=ajoutPos(piocheN,q,choix.couleurs,choix.formes);
   mainN:=ajoutFin(main,piece1^.couleurs,piece1^.formes);
   mainN:=SuppVal(mainN,choix.couleurs,choix.formes);
   res.pioche:=piocheN;
   res.main:=mainN;
   remplace:=res;
END;

(*=============================================================================================*)

(*
 ------------------------------------------------------------------------------------
 -- Fonction          : jouerPieceMain
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : on joue une certaine donc on l'enleve de la main
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function jouerPieceMain(main: ptr_piece; p:Integer):typeMain;
Var
   choix : piece;
   mainN : ptr_piece;
   res	 : typeMain;


Begin
   choix:=choixPiece(main,p);
   mainN:=SuppVal(main,choix.couleurs,choix.formes);
   res.main:=mainN;
   res.piece:=choix;
   jouerPieceMain:=res;
End;

(*=====================================================================================*)

(*
 ------------------------------------------------------------------------------------
 -- Fonction          : placementPiece
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : où placer les piece sur la table de jeu
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function placementPiece(Grille : typeGrille;couleurs,formes,ligne,colone:integer):typeGrille;
BEGIN
   grille[ligne,colone]^.couleurs:=couleurs;
   grille[ligne,colone]^.formes:=formes;
   placementpiece:=grille;
End;

(*================================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : placementdsgrille
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : placer une piece donnée dans la grille
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function placementdsgrille(grille : typegrille;piece:piece;l,c:integer):typegrille;
VAR
   bool	      : Boolean;
Begin
   bool:=verification(grille,piece.couleurs,piece.formes,l,c);
   if bool then
   Begin
      writeln('Vous pouvez placer la pièce');
      grille:=placementPiece(grille,piece.couleurs,piece.formes,l,c);
   End
   Else
   Begin
      writeln('Vous ne pouvez pas placer la pièce');
   End; 
   placementdsgrille:=grille;
End;

(*===============================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : premierplacement
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : placer la premiere piece
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function premierplacement(grille : typeGrille;couleurs,formes:integer;taille:integer):typeGrille;
BEGIN
   grille[taille DIV 2,taille DIV 2]^.couleurs:=couleurs;
   grille[taille DIV 2,taille DIV 2]^.formes:=formes;
   premierplacement:=grille;
END;

(*=====================================Fonction de verification==================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : veriLigne
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : verifie si la piece peut etre poser a cette endroit sur la ligne
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)

Function veriLigne1(tab	: typeGrille; couleurs,formes,ligne,colone : integer): boolean;
VAR
   verification	: boolean;
BEGIN
   verification:=true;
   if (tab[ligne,colone-1]^.couleurs<>0)then
   begin
      if ((tab[ligne,colone-1]^.couleurs<>couleurs) and (tab[ligne,colone-1]^.formes<>formes)) or ((tab[ligne,colone-1]^.couleurs=couleurs) and (tab[ligne,colone-1]^.formes=formes)) then
      begin
	 verification:=false;
      end
      Else
      Begin
	 verification:=veriLigne1(tab,couleurs,formes,ligne,colone-1);
      End;
   end;
   veriLigne1:=verification;
END;

Function veriLigne2(tab	: typeGrille; couleurs,formes,ligne,colone : integer): boolean;
VAR
   verification	: Boolean;
BEGIN
   verification:=true;
   if (tab[ligne,colone+1]^.couleurs<>0)then
   begin
      if ((tab[ligne,colone+1]^.couleurs<>couleurs) and (tab[ligne,colone+1]^.formes<>formes)) or ((tab[ligne,colone+1]^.couleurs=couleurs) and (tab[ligne,colone+1]^.formes=formes)) then
      begin
	 verification:=false;
      end
      Else
      Begin
	 verification:=veriLigne2(tab,couleurs,formes,ligne,colone+1);
      End;
   end;
   veriLigne2:=verification;
END;

(*===============================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : veriColone
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : verifie si la piece peut etre poser a cette endroit sur la colone
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)

Function veriColone1(tab : typeGrille; couleurs,formes,ligne,colone : integer): boolean;
VAR
   verification	: boolean;
BEGIN
   verification:=true;
   if (tab[ligne-1,colone]^.couleurs<>0) then
   begin
      if ((tab[ligne-1,colone]^.couleurs<>couleurs) and (tab[ligne-1,colone]^.formes<>formes))or ((tab[ligne-1,colone]^.couleurs=couleurs) and (tab[ligne-1,colone]^.formes=formes)) then
      begin
	 verification:=false;
      end
      Else
      Begin
	 verification:=veriColone1(tab,couleurs,formes,ligne-1,colone);
      End;
   end;
   veriColone1:=verification;
END;


Function veriColone2(tab : typeGrille; couleurs,formes,ligne,colone : integer): boolean;
VAR
   verification	: Boolean;
BEGIN
   verification:=true;
   if (tab[ligne+1,colone]^.couleurs<>0)then
   begin
      if ((tab[ligne+1,colone]^.couleurs<>couleurs) and (tab[ligne+1,colone]^.formes<>formes)) or ((tab[ligne+1,colone]^.couleurs=couleurs) and (tab[ligne+1,colone]^.formes=formes)) then
      begin
	 verification:=false;
      end
      Else
      Begin
	 verification:=veriColone2(tab,couleurs,formes,ligne+1,colone);
      End;
   end;
   veriColone2:=verification;
END;

(*=============================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : verificationplacement
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : verifie si la piece a bien une voisine pour etre placé
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function verificationplacement(grille : typeGrille;ligne,colone:integer):Boolean;
Var
   bool	: boolean;
Begin
   bool:= ((grille[ligne-1,colone]^.couleurs<>0) or (grille[ligne+1,colone]^.couleurs<>0) or (grille[ligne,colone+1]^.couleurs<>0) or (grille[ligne,colone-1]^.couleurs<>0));
   verificationplacement:=bool;
End;

(*=============================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : verification
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : place la piece et verifie si la piece peut etre poser a cette endroit
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)

Function verification(grille : typeGrille;couleurs,formes,ligne,colone:integer ):Boolean;
VAR
   bool1,bool2,bool3,bool4,bool5 : Boolean;
BEGIN
   bool5:=verificationplacement(grille,ligne,colone);
   bool1:=veriLigne1(grille,couleurs,formes,ligne,colone);
   bool2:=veriLigne2(grille,couleurs,formes,ligne,colone);
   bool3:=veriColone1(grille,couleurs,formes,ligne,colone);
   bool4:=veriColone2(grille,couleurs,formes,ligne,colone);
   verification:=(bool1) and (bool2)and(bool3)and(bool4)and(bool5); 
END;

(*===================================Points======================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : Compteligne/comptecolonne
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               :compte les points en lignes et en colonne  + on apelle recursivement à droite et à gauche                        d'ou les 4 fonctions
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function compteligne1(tab : typeGrille;ligne,colone,points:integer):Integer;
VAR
   nb :Integer;
BEGIN
   nb:=0;
   if (tab[ligne,colone-1]^.couleurs<>0)then
   begin
      nb:=nb+1;
      points:=points+1;     
      points:=compteligne1(tab,ligne,colone-1,points);
   End;
   if nb=6 then
   Begin
      points:=points+6;
   End;
   compteligne1:=points;
End;

Function compteligne2(tab : typeGrille;ligne,colone,points:integer):Integer;
VAR
   nb : Integer;

Begin
   nb:=0;

   if(tab[ligne,colone+1]^.couleurs<>0)then
   
   begin
      nb:=nb+1;
      points:=points+1;
      points:=compteligne2(tab,ligne,colone+1,points);
   End;
   if nb=6 then
   Begin
      points:=points+6;
   End;
   compteligne2:=points;
END;

Function comptecolone1(tab : typeGrille;ligne,colone,points: integer): Integer;
VAR
   nb	: Integer;
BEGIN
   nb:=0;
   if (tab[ligne-1,colone]^.couleurs<>0) then
   
   begin
      nb:=nb+1;
      points:=points+1;
     
      points:=comptecolone1(tab,ligne-1,colone,points);
   End;
   if nb=6 then
   Begin
      points:=points+6;
   End;
   comptecolone1:=points;
End;
Function comptecolone2(tab : typeGrille;ligne,colone,points : integer): Integer;
VAR
   nb : Integer;

Begin
   nb:=0;

   if (tab[ligne+1,colone]^.couleurs<>0)then
   begin
      nb:=nb+1;
      points:=points+1;
      points:=comptecolone2(tab,ligne+1,colone,points);
   End;
   if nb=6 then
   Begin
      points:=points+6;
   End;
   comptecolone2:=points;
END;  
   
   

Function compte(grille : typeGrille;tab:array of integer;g,compteur:integer):Integer;
VAR
   res,i : Integer;
   
Begin
   res:=1;
   if (compteur=1) then
   begin
      for i:=0 to high(tab) do
      begin
	 res:=comptecolone1(grille,g,tab[i],res);
	 res:=comptecolone2(grille,g,tab[i],res);
      end;
      res:=compteligne1(grille,g,tab[i],res);
      res:=compteligne2(grille,g,tab[i],res);
   end
   else
   begin
      for i:=0 to high(tab) do
      begin
	 res:=compteligne1(grille,tab[i],g,res);
	 res:=compteligne2(grille,tab[i],g,res);
      end;
      res:=comptecolone1(grille,tab[i],g,res);
      res:=comptecolone2(grille,tab[i],g,res);
   end;
   compte:=res;
End;

(*===================================tour======================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : doublons
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : renvoie une main sans piece en double
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)

Function copieListe(l,tmp : ptr_piece):ptr_piece;
Begin
   if (l<>NIL) then
      begin
     tmp:=ajoutfin(tmp,l^.couleurs,l^.formes);
     l:=copieListe(l^.suivant,tmp);
      end;
   copieListe:=tmp;
End;

Function suppttVal(l    : ptr_piece;couleurs,formes : Integer):ptr_piece;
Var
   n : ptr_piece;
Begin
   If (l<>Nil) then
      If  (couleurs<>l^.couleurs) or (formes<>l^.formes) then
      Begin
     If (l^.suivant<>Nil)  then
        l^.suivant:=suppttVal(l^.suivant,couleurs,formes)
      end else
      begin
     n:=l^.suivant;
     dispose(l);
     l:=n;
     If l<>Nil then
        l:=suppttVal(l,couleurs,formes);
      End;
   suppttVal:=l;
End;

Function doublons(l : ptr_piece):ptr_piece;
VAR
   nouvel : ptr_piece;
Begin
   nouvel:=copieListe(l,NIL);
   if (nouvel<>Nil) then
   Begin    
      nouvel^.suivant:=suppttVal(nouvel^.suivant,nouvel^.couleurs,nouvel^.formes);
      nouvel^.suivant:=doublons(nouvel^.suivant);   
   End;
   doublons:=nouvel;
End;

(*========================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : recherchec
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : recherche une certaine couleurs dans la main
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)

Function recherchec(main : ptr_piece;couleurs,formes:Integer):Integer;
VAR
   res : Integer;
   tmp : ptr_piece;
Begin
   res:=1;
   tmp:=doublons(main);
   While  (tmp<>Nil) do
   Begin
      if (couleurs=tmp^.couleurs) and (formes<>tmp^.formes) then
      Begin
     res:=res+1;
      End;
      tmp:=tmp^.suivant;
   End;
   recherchec:=res;
End;
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : recherchef
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : recherche une certaine formes dans la main
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function recherchef(main : ptr_piece;couleurs,formes:Integer):Integer;
VAR
   res : Integer;
   tmp : ptr_piece;
Begin
   res:=1;
   tmp:=doublons(main);
   While  (tmp<>Nil) do
   Begin
    
      if (formes=tmp^.formes) and (couleurs<>tmp^.couleurs) then
      Begin
     res:=res+1;
      End;
      tmp:=tmp^.suivant;
   End;
   recherchef:=res;
End;

(*
 ------------------------------------------------------------------------------------
 -- Fonction          : nbElements
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : compte le nombre d'elements dans une liste
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)

Function nbElements(main : ptr_piece):Integer;
VAR
   res1,res2,res4,res3 : Integer;
   couleurs1,formes1   : integer;
   tmp		       : ptr_piece;
Begin
   res3:=0;
   res4:=0;
   tmp:=main;
   While (tmp<>NIl) do
   begin
      couleurs1:=tmp^.couleurs;
      formes1:=tmp^.formes;
      tmp:=tmp^.suivant;
     
      res1:=recherchec(main,couleurs1,formes1);
      res2:=recherchef(main,couleurs1,formes1);
     
      if (res1>res3) then
	 begin
	    res3:=res1;
	 end;
      if (res2>res4) then
	 begin
	    res4:=res2;
	 end;
   end;
   if (res3>res4) then
      begin
	 Writeln();
	 writeln('Vous avez plus de couleurs dans votre main');
	 nbElements:=res3;
      end
   else
      begin
	 Writeln();
	 writeln('Vous avez plus de formes dans votre main');
	 nbElements:=res4;
      end;
End;

(*============================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : demandejoueur
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : fonction qui demande au joueur et renvoi les paramètre du joueur
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)

Function demandejoueur(pioche:ptr_piece):typejoueurs;
VAR
   joueur  : typejoueurs;
BEGIN
   writeln('Entrer votre age');
   readln(joueur.age);
   writeln('Entrer votre nom');
   readln(joueur.nom);
   joueur.main:=creerMain(pioche);
   joueur.points:=0;
   demandejoueur:=joueur;
END;

(*======================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : compareage
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : compare les age de 2 joueur si ils ont le meme nombre de posibilités de jeu
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)

Function compareage(age1,age2 : Integer):Integer;
VAR
   res : Integer;
Begin
   res:=age2;
   if (age1>=age2) then
   Begin
      res:=age1;
   End;
   compareage:=res;
End;

(*===============================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : creerordre
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : creer l'ordre dans lequel les joueur joue
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function creerordre(nb :Integer; pioche:ptr_piece):senstour;
VAR
   joueur,chgt	       : typejoueurs;
   i,elt1,elt2,acc,u,j : Integer;
   pretour	       : senstour;

Begin
   setlength(pretour,nb);
   acc:=-1;
   elt2:=0;
   For i:= 0 to nb-1 do
   Begin
      joueur:=demandejoueur(pioche);
      pretour[i]:=joueur;
      pioche:=joueur.main.pioche;
      for j:=0 to i do
      begin
	 pretour[j].main.pioche:=pioche;
	 writeln();
      end;
      Writeln('La pioche');
      affiche(pioche);
      writeln();
      writeln('La main de ', pretour[j].nom);
      affiche(joueur.main.main);
      elt1:=nbElements(joueur.main.main);
      if (elt1=elt2) then
      Begin
	 u:=compareage(pretour[nb].age,pretour[acc].age);
	 if (u=pretour[nb].age) then
	 begin
	    elt2:=elt1;
	    chgt:=pretour[0];
	    pretour[0]:=pretour[i];
	    pretour[i]:=chgt;
	 end;     
      end;
      if (elt1>elt2) then
      begin
	 elt2:=elt1;
	 chgt:=pretour[0];
	 pretour[0]:=pretour[i];
	 pretour[i]:=chgt;
      end; 
   End;
   writeln('Le joueur qui commençe est : ', pretour[0].nom);
   writeln();
   creerordre:=pretour;
End;


(*===============================Condition de fin du jeu========================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : mainvide
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : verifie si on a une des mains des joueurs qui est vide
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function mainvide(tour :  senstour):Boolean;
VAR
   mainV : Boolean;
   i     : Integer;

Begin
   mainV:=False;
   For i:=0 to high(tour) do
   Begin
      if (tour[i].main.main=Nil) then
      Begin
	 mainV:=True;
      End;
   ENd;
   mainvide:=mainV;
End;

(*=============================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : finjeu
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : condition pour lequel le jeu s'arrete
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function finjeu(pioche : ptr_piece;tour:senstour):boolean;
VAR
   fin,mainV : boolean;

Begin
   mainV:=mainvide(tour);
   fin:=False;
   if (pioche=Nil)  and (mainV) then
   Begin
      fin:=True;
   End;
   finjeu:=fin;
End;

(*
 ------------------------------------------------------------------------------------
 -- Fonction          : maxpoints
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : compare le score des joueurs du tableau et renvoi le gagnant
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Function maxpoints(tour	: senstour):typejoueurs;
VAR
   i : Integer;
   gagnant : typejoueurs;

Begin
   gagnant:=tour[0];
   For i:=1 to high(tour) do
   Begin
      if (tour[i].points>gagnant.points) then
      Begin
	 gagnant:=tour[i];
      End;
   End;
   maxpoints:=gagnant;
End;

END.		    
