PROGRAM Qwirkle;

uses sysutils,Crt,Unitafficheprojet,UnitType,Unitprojet,UnitIA;
{$i-}

(*
 ------------------------------------------------------------------------------------
 -- Fonction          : remplacertt
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : permet de remplacer un nombre de pions que l'on veut 
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Function remplacertt(main : ptr_piece;fin:toutEnUN):toutEnUn;
VAR
   h,u,i   : Integer;
   nouveau : typeMain;
Begin
   writeln('Combien de piece voulez vous enlever ?');
   readln(h);
   For i:= 0 to h-1 do
   Begin
      
      
      writeln('Choisir une pièce pour la remplacer ?');
      readln(u);
      nouveau:=remplace(main,fin.pioche,u);

      fin.pioche:=nouveau.pioche;
      writeln('Nouvelle pioche');
      affiche(fin.pioche);
      writeln();

      fin.main:=nouveau.main;
      main:=nouveau.main;
      writeln('Nouvelle main');
      affiche(fin.main);
      writeln();  
   End;
 
   remplacertt:=fin;
End;
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : jouertt
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : permet de jouer un nombre de pions que l'on veut 
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Function jouertt(main : ptr_piece;fin:toutEnUN;n:integer):toutEnUn;
VAR
   w,a,i,j	: Integer;
   nouveau	: typeMain;
   piece1	: ptr_piece;
   c,l,compteur	: integer;
   tab		: array of integer;

Begin
   j:=1;
   i:=0;
   writeln('Combien de piece voulez vous jouer ?');
   readln(w);
   setlength(tab,w);
   if (w>0) then
   Begin   
      writeln('Voulez vous jouer sur une (1) ligne ou une (2) colonne ?');
      readln(compteur);
      if (compteur=1) then
      begin
	 writeln('A quelle ligne voulez jouer la piece ?');
	 readln(l);
	 For i:= 0 to w-1 do
	 Begin
	    setlength(tab,w);
	    writeln('Choisir une pièce pour la jouer ?');
	    readln(a);
	    nouveau:=jouerPieceMain(main,a);
	    
	    writeln('A quelle colonne voulez jouer la piece ?');
	    readln(c);
	    
	    tab[i]:=c;
	    fin.grille:=placementdsgrille(fin.grille,nouveau.piece,l,c);
	    
      
	    afficherGrille(fin.grille,n);
	    
	    fin.main:=nouveau.main;
	    main:=nouveau.main;
	    if (main<>Nil) then
	    Begin
	       write('Votre main : ');
	       affiche(fin.main);
	       writeln();
	    End;
	 End;
	 fin.points:=compte(fin.grille,tab,l,compteur);
      end
   else
      begin
	 writeln('A quelle colonne voulez jouer la piece ?');
	 readln(c);
	 For i:= 0 to w-1 do
	 Begin
	    setlength(tab,w);
	    writeln('Choisir une pièce pour la jouer ?');
	    readln(a);
	    nouveau:=jouerPieceMain(main,a);
	    
	    writeln('A quelle ligne voulez jouer la piece ?');
	    readln(l);
	    
	    tab[i]:=l;
	    fin.grille:=placementdsgrille(fin.grille,nouveau.piece,l,c);
	    
	    
	    afficherGrille(fin.grille,n);

	    
	    fin.main:=nouveau.main;
	    main:=nouveau.main;
	    if (main<>Nil) then
	    Begin   
	       write('Votre main : ');
	       affiche(fin.main);
	       writeln();
	    End;
	 End;
	 fin.points:=compte(fin.grille,tab,c,compteur);
	 writeln('Votre score : ',fin.points);
      end;
      
      while ((fin.pioche<>NIL)and(j<=w)) do
      begin
	 piece1:=creerPiece(fin.pioche^.couleurs,fin.pioche^.formes);
	 fin.pioche:=SuppDeb(fin.pioche);
	 main:=ajoutFin(main,piece1^.couleurs,piece1^.formes);
	 j:=j+1;
      end;
   End
   else
   begin
      fin.main:=main;
   end;
   if (fin.main<>Nil) then
   Begin
      writeln('Nouvelle main');
      affiche(fin.main);
      writeln();
   End;
   jouertt:=fin;
End;
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : jouerttpremier
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : permet de jouer le premier pion au milieu de la grille
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Function jouerttpremier(main : ptr_piece;fin:toutEnUn;n:integer):toutEnUn;
Var
   a,j	   : Integer;
   nouveau : typeMain;
   piece1  : ptr_piece;

Begin
   j:=0;
   writeln('Choisir une pièce pour la jouer ?');
   readln(a);
   nouveau:=jouerPieceMain(main,a);
   
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
   jouerttpremier:=fin;
End;
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : testrempljoue
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : appele les fonctions jouer et remplacer + permet de faire un choix entre les deux 
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Function testrempljoue(main : ptr_piece;fin : toutEnUn;n,compteur:integer):toutEnUn;
VAR
 
   c  : Integer;

Begin
   writeln('0 : Remplacer Pièces, 1 : Jouer Pièces');
   readln(c);
   if (c=0) then
   Begin  
      fin:=remplacertt(main,fin);
   End
   Else
   Begin
      if (compteur=0) then
      begin
	 fin:=jouerttpremier(main,fin,n);
      end
      else
      begin
	 fin:=jouertt(main,fin,n);
      end;
   End;
   testrempljoue:=fin;
End;
   
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : run
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : Permet de faire tourner le jeu selon le choix de l'utilisateur 
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Function run(fin : toutEnUN; tour:senstour; nbj,c,n,compteur:Integer):toutEnUn;
Begin  

   Clrscr();
   tour[0].points:=1;
   affichergrille(fin.grille,n);
   writeln('C''est le tour de  ', tour[c mod nbj].nom);
   writeln('Ta main ', tour[c mod nbj].nom);
   affiche(tour[c mod nbj].main.main);
   affichepos(tour[c mod nbj].main.main);
   writeln();
   
   fin:=testrempljoue(tour[c mod nbj].main.main,fin,n,compteur);
   tour[c mod nbj].main.main:=fin.main;
   tour[c mod nbj].points:=tour[c mod nbj].points+fin.points;
   writeln('Votre score ',  tour[c mod nbj].points);
   
  
   run:=fin;
End;

      
      
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : appelrun
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : Mise un place du jeu + appele des fonctions de fin du jeu 
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------*)
Procedure appelrun(fin :toutEnUN ;tour:senstour;nbj,n:Integer);
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
      fin:=run(fin,tour,nbj,c,n,compteur);
      writeln();
      c:=c+1;
      compteur:=compteur+1;
      bool:=finjeu(fin.pioche,tour);
   End;
   writeln('Le jeu est finis');
   winner:=maxpoints(tour);
   writeln('Le gagnant est ', winner.nom, ' avec ', winner.points, ' points');
End;





(*
 ------------------------------------------------------------------------------------
 -- Fonction          : param
 -- Auteur            : Luca Ordronneau
 --
 -- But               : prendre les différents parametres pour les fichiers
 -- Pré conditions    : aucune
 -- Post conditions   : retourne les parametres selon le fichiers
 ------------------------------------------------------------------------------------*)
Function param(parametre :typeParam ):typeParam;
VAR
   i	     : integer;
BEGIN
   if (paramCount mod 2 <>0) then
   Begin
      writeln('Erreur');
   End
   Else
   Begin
      For i:=1 to paramCount do
      Begin
	 if paramStr(i) = '-j' then
	 Begin  
	    parametre.j := paramStr(i+1);
	 End;
	 if paramStr(i) = '-c' then
	 Begin
	    parametre.c := StrToInt(paramStr(i+1));
	 End;
	 if paramStr(i) = '-f' then
	 Begin
	    parametre.f := StrToInt(paramStr(i+1));
	 End;
	 if paramStr(i) = '-t' then
	 Begin
	    parametre.t := StrToInt(paramStr(i+1));
	 End;
      end;
   End;
   param:=parametre;
end;

(*
 ------------------------------------------------------------------------------------
 -- Procedure         : lecturejeu
 -- Auteur            : Luca Ordronneau
 --
 -- But               :afficher selon la premiere ligne du fichier le jeu 
 -- Pré conditions    :
 -- Post conditions   : affiche selon la première ligne du fichier le jeu 
 ------------------------------------------------------------------------------------*)   
 

PROCEDURE lecturejeu(nbtuile,nbcouleurs,nbformes :Integer);
VAR
   parametre	    : typeParam;
   grille	    : typeGrille;
   pioche	    : ptr_piece;
   nbj		    : Integer;
   tour		    : senstour;
   fin		    : toutEnUn;
   n		    : integer;
   
BEGIN
   parametre.c:=6;
   parametre.f:=6;
   parametre.t:=3;
   parametre:=param(parametre);
   
   nbcouleurs:=parametre.c;
   nbformes:=parametre.f;
   nbtuile:=parametre.t;
   
   n:=nbcouleurs*nbformes*nbtuile;
   if (n>45) then
      begin
	 n:=45;
      end;
   

   writeln('La grille de jeu');
   grille:=initGrille(n);
   afficherGrille(grille,n);
   writeln();

   writeln('La pioche initiale :');
   pioche:=initpioche(nbtuile,nbcouleurs,nbformes);
   affiche(pioche);
   writeln();
   fin.pioche:=pioche;
   fin.grille:=grille;

   writeln('Combien voulez vous de joueurs ?');
   readln(nbj);

   tour:=creerordre(nbj,pioche);
   appelrun(fin,tour,nbj,n);

END;
(*
 ------------------------------------------------------------------------------------
 -- Procedure         : lecturejeuIA
 -- Auteur            : Luca Ordronneau
 --
 -- But               :aPermet de lire le jeu avec les IA
 -- Pré conditions    :
 -- Post conditions   : affiche selon la première ligne du fichier le jeu 
 ------------------------------------------------------------------------------------*)   
Procedure lecturejeuIA(nbtuile,nbcouleurs,nbformes :Integer);
VAR
   parametre	    : typeParam;
   grille	    : typeGrille;
   pioche	    : ptr_piece;
   nbj		    : Integer;
   tour		    : senstour;
   fin		    : toutEnUn;
   n		    : integer;
   
BEGIN
   parametre.c:=6;
   parametre.f:=6;
   parametre.t:=3;
   parametre:=param(parametre);
   
   nbcouleurs:=parametre.c;
   nbformes:=parametre.f;
   nbtuile:=parametre.t;
   
   n:=nbcouleurs*nbformes*nbtuile;
   if (n>45) then
      begin
	 n:=45;
      end;
   

   writeln('La grille de jeu');
   grille:=initGrille(n);
   afficherGrille(grille,n);
   writeln();

   writeln('La pioche initiale :');
   pioche:=initpioche(nbtuile,nbcouleurs,nbformes);
   affiche(pioche);
   writeln();
   fin.pioche:=pioche;
   fin.grille:=grille;

   writeln('Combien voulez vous d''IA ?');
   readln(nbj);
   tour:=ordreIA(nbj,pioche);
   appelrunIA(fin,tour,nbj,n);

END;

VAR
   nbcouleurs,nbformes,nbtuile,j : integer;
Begin
   clrScr();
   Randomize;
   nbcouleurs:=0;
   nbformes:=0;
   nbtuile:=0;

   writeln('Voulez vous regarder une simulation avec 2 IA (1), ou Voulez vous jouer avec un ami(e)s (2)');
   readln(j);
   if (j=1) then
   begin
      lecturejeuIA(nbtuile,nbcouleurs,nbformes);
   End
   Else
   Begin
      lecturejeu(nbtuile,nbcouleurs,nbformes);
   End;
END.
