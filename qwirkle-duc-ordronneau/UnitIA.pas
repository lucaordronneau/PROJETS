Unit UnitIA;

Interface
Uses Unitprojet,Unitafficheprojet,UnitType;

Function ordreIA(nb :Integer; pioche:ptr_piece):senstour;
Function parcoursGrille(main : ptr_piece;fin:toutEnUN;compteur:Integer;piece:piece):toutEnUN;
Function parcoursMain(main : ptr_piece;fin:toutEnUn;n,compteur:Integer):toutEnUn;
Function runIA(fin : toutEnUN; tour:senstour; nbj,c,n,compteur:Integer):toutEnUn;
Procedure appelrunIA(fin :toutEnUN ;tour:senstour;nbj,n:Integer);
Function jouerttpremierIA(main : ptr_piece;fin:toutEnUn;n:integer):toutEnUn;
Function testrempljoueIA(main : ptr_piece;fin : toutEnUn;n,compteur:integer):toutEnUn;

Implementation
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : OrdreIA
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : permet de demander le nbes d'IA
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Function ordreIA(nb :Integer; pioche:ptr_piece):senstour;
VAR
   joueur,chgt	       : typejoueurs;
   i,elt1,elt2,j : Integer;
   pretour	       : senstour;

Begin
   setlength(pretour,nb);
   elt2:=0;
   For i:= 0 to nb-1 do
   Begin
      pretour[0].nom:='IA0';
      pretour[1].nom:='IA1';
      pretour[2].nom:='IA2';
      pretour[3].nom:='IA3';
      joueur.main:=creerMain(pioche);
      pretour[i].main:=joueur.main;
      pioche:=joueur.main.pioche;
      for j:=0 to i do
      begin
	 pretour[j].main.pioche:=pioche;
	 writeln();
      end;
      Writeln('La pioche');
      affiche(pioche);
      writeln();
      affiche(joueur.main.main);
      elt1:=nbElements(joueur.main.main);
      if (elt1>elt2) then
      begin
	 elt2:=elt1;
	 chgt:=pretour[0];
	 pretour[0]:=pretour[i];
	 pretour[i]:=chgt;
      end; 
   End;
   ordreIA:=pretour;
End;

(*
 ------------------------------------------------------------------------------------
 -- Fonction          : parcoursGrille
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : parcours la grille est met un pion des que possible
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)

Function parcoursGrille(main :ptr_piece ;fin:toutEnUN;compteur:Integer;piece:piece):toutEnUN;
VAR
   i,j	      : Integer;
   verif,bool : Boolean;
   

Begin
   bool:=true;;
   For i:=1 to high(fin.grille)-1 do
   Begin
      For j:=1 to high(fin.grille)-1 do
      Begin
	 if (bool) and (main<>Nil) then
	 begin
	    verif:=verification(fin.grille,piece.couleurs,piece.formes,i,j);
	    if (verif) then
	    Begin
	       fin.grille:=placementPiece(fin.grille,piece.couleurs,piece.formes,i,j);
	       bool:=false;
	    End;
	 end;
      End;     
   End;
   (*if  (bool) and (main<>Nil) then
   begin
      nouveau:=remplace(main,fin.pioche,0);
      fin.pioche:=nouveau.pioche;
      writeln('Nouvelle pioche');
      affiche(fin.pioche);
      writeln();
      
      fin.main:=nouveau.main;
      main:=nouveau.main;
      if (main<>Nil) then
      Begin
	 writeln('Nouvelle main');
	 affiche(fin.main);
	 writeln();
      End;
   end;*)
   parcoursGrille:=fin;
End;

(*
 ------------------------------------------------------------------------------------
 -- Fonction          : ParcoursMain
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : parcours la main jusqu'a trouver un pion possible sinon passe a l'autre joueur 
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Function parcoursMain(main : ptr_piece;fin:toutEnUn;n,compteur:Integer):toutEnUn;
VAR
   nouveau : typeMain;
   p,j,w   : Integer;
   piece1  : ptr_piece;
   bool	   : boolean;
BEGIN
   p:=0;
   w:=1;
   j:=0;
   bool:=true;

   while (main<>NIL) and (bool) do
   begin
     
      nouveau:=jouerPieceMain(main,p);
  
      fin:=parcoursgrille(main,fin,compteur,nouveau.piece);

     
        
      afficherGrille(fin.grille,n);

      fin.main:=nouveau.main;
      main:=nouveau.main;
      
      if (main<>Nil) then
      Begin
	 write('Votre main : ');
	 affiche(fin.main);
	 writeln();
      End;     
      while ((fin.pioche<>NIL)and(j<=w)) do
      begin
	 piece1:=creerPiece(fin.pioche^.couleurs,fin.pioche^.formes);
	 fin.pioche:=SuppDeb(fin.pioche);
	 main:=ajoutFin(main,piece1^.couleurs,piece1^.formes);
	 j:=j+1;
      end;
      p:=p+1;
      bool:=false;
   ENd;
      
   if (fin.main<>Nil) then
   Begin
      writeln('Nouvelle main');
      affiche(fin.main);
      writeln();
   End;
   parcoursMain:=fin;
End;
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : jouerttpremeirIA 
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : jouer la première piece de la main 
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)

Function jouerttpremierIA(main : ptr_piece;fin:toutEnUn;n:integer):toutEnUn;
Var
     j	   : Integer;
   nouveau : typeMain;
   piece1  : ptr_piece;

Begin
   j:=0;
   nouveau:=jouerPieceMain(main,0);

   fin.grille:=premierplacement(fin.grille,nouveau.piece.couleurs,nouveau.piece.formes,n);
   
   afficherGrille(fin.grille,n);

   fin.main:=nouveau.main;
   main:=nouveau.main;
   
   while ((fin.pioche<>NIL)and(j<1)) do
   begin
      piece1:=creerPiece(fin.pioche^.couleurs,fin.pioche^.formes);
      fin.pioche:=SuppDeb(fin.pioche);
      main:=ajoutFin(main,piece1^.couleurs,piece1^.formes);
      j:=j+1;
   end;
   writeln('Nouvelle main');
   affiche(fin.main);
   writeln();
   jouerttpremierIA:=fin;
End;
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : testrempljoueIA
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : appelle le sdeux fonctions D'IA 
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Function testrempljoueIA(main : ptr_piece;fin : toutEnUn;n,compteur:integer):toutEnUn;
Begin
   if (compteur=0) then
   begin
      fin:=jouerttpremierIA(main,fin,n);
   end
   else
   begin
      fin:=parcoursMain(main,fin,n,compteur);
   end;
   testrempljoueIA:=fin;
End;
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : runIA
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : lance le jeu 
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Function runIA(fin : toutEnUN; tour:senstour; nbj,c,n,compteur:Integer):toutEnUn;

Begin
   writeln('C''est le tour de  ', tour[c mod nbj].nom);
   writeln('Ta main ', tour[c mod nbj].nom);
   affiche(tour[c mod nbj].main.main);
   affichepos(tour[c mod nbj].main.main);
   writeln();

   fin:=testrempljoueIA(tour[c mod nbj].main.main,fin,n,compteur);

   tour[c mod nbj].main.main:=fin.main;
   tour[c mod nbj].points:=tour[c mod nbj].points+fin.points;
   runIA:=fin;
End;
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : appelRunIA
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : appel la fonction IA et affcihe le resultat final gangnant 
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Procedure appelrunIA(fin :toutEnUN ;tour:senstour;nbj,n:Integer);
VAR
   bool	      : Boolean;
   c,compteur : Integer;
   winner     : typejoueurs;
   
Begin
   compteur:=0;
   fin.pioche:=tour[0].main.pioche;
   c:=0;
   bool:=finjeu(fin.pioche,tour);
   While (not bool) do
   Begin

      fin:=runIA(fin,tour,nbj,c,n,compteur);

      writeln();
      c:=c+1;
      compteur:=compteur+1;
      bool:=finjeu(fin.pioche,tour);
   End;
   writeln('Le jeu est finis');
   winner:=maxpoints(tour);
   writeln('Le gagnant est ', winner.nom);
End;

   
END.
