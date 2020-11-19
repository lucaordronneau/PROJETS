(*
 ------------------------------------------------------------------------------------
 -- Fichier           : unitafficheprojet
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 18/05/18
 --
 -- But               :
 -- Remarques         : unit qui regroupe l'esemble de nos fonctions pour afficher et initialiser
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Unit Unitafficheprojet;



interface
Uses UnitType,sysutils,Crt;

Procedure affiche(l : ptr_piece);
Procedure affiche2(l : piece);
PROCEDURE premiereligne(i,c : integer);
PROCEDURE premierecolone(i,j,c : integer);
PROCEDURE afficherGrille(grille : typeGrille;n:integer);
Function creerPiece(couleurs,formes : Integer):ptr_piece;
Function ajoutPos(l : ptr_piece; p,couleurs,formes:Integer):ptr_piece;
Function initpioche(nbid,nbcoul,nbfor :Integer):ptr_piece;
Function creerMain(l : ptr_piece):typeMain;
FUNCTION initGrille(n :integer ):typeGrille;
Procedure affichepos(main : ptr_piece);


implementation

(*
 ------------------------------------------------------------------------------------
 -- Fonction          : affiche
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : affiche une liste de piece (main ou pioche)
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Procedure affiche(l : ptr_piece);
begin
   if(l^.suivant<>nil) then
   begin
      Case l^.couleurs of
	1: TextColor(blue);
	2: TextColor(red);
	3: TextColor(green);
	4: TextColor(cyan);
	5: TextColor(yellow);
	6: TextColor(magenta);
      End;
      Case l^.formes of
	1: write(' C ');
	2: write(' O ');
	3: write(' X ');
	4: write(' H ');
	5: write(' W ');
	6: write(' S ');
      End;
      write('|');
      affiche(l^.suivant);
   end
   else
   begin
      Case l^.couleurs of
	1: TextColor(blue);
	2: TextColor(red);
	3: TextColor(green);
	4: TextColor(cyan);
	5: TextColor(yellow);
	6: TextColor(magenta);
      End;
      Case l^.formes of
	1: write(' C ');
	2: write(' O ');
	3: write(' X ');
	4: write(' H ');
	5: write(' W ');
	6: write(' S ');
      End;
   end;
   TextColor(White);
end;

(*===================================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : affiche2
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : affiche une seule piece
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Procedure affiche2(l : piece);
begin
   Case l.couleurs of
     1	: TextColor(blue);
     2	: TextColor(red);
     3	: TextColor(green);
     4	: TextColor(cyan);
     5	: TextColor(yellow);
     6	: TextColor(magenta);
   End;
   Case l.formes of
     1	: write(' C ');
     2	: write(' O ');
     3	: write(' X ');
     4	: write(' H ');
     5	: write(' W ');
     6	: write(' S ');
   end;
   TextColor(White);
end;

(*===================================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : premiereligne
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : affiche les chiffre de la premiere ligne
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
PROCEDURE premiereligne(i,c : integer);

BEGIN
   if (i=0) then
      begin
	 if (c<10) then
	    begin
	       write(' ',c,' ');
	    end
	 else
	    begin
	       write(c,' ');
	    end;
      end;
END;

(*===================================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : premierecolone
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : affiche les chiffre de la premiere colones
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
PROCEDURE premierecolone(i,j,c : integer);

BEGIN
   if (j=0) and (i<>0) then
      begin
	 if (c<10) then
	    begin
	       write(' ',c,' ');
	    end
	 else
	    begin
	       write(c,' ');
	    end;
      end;
END;

(*==================================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : afficheGrille
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : affiche notre grille de jeu
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)   
PROCEDURE afficherGrille(grille	: typeGrille;n:integer);
VAR
   i,j,c,c2 : Integer;   
BEGIN
   c:=0;
   c2:=1;
   For i:=0 to n do
   Begin
      For j:= 0 to n do
      Begin
	 premiereligne(i,c);
	 c:=c+1;
	 premierecolone(i,j,c2);
	 if (grille[i,j]^.couleurs = 0) and (grille[i,j]^.formes = 0) and (i<>0) and (j<>0) then
	 Begin
	    write(' - ');
	 End
	 Else
	 Begin
	    Case grille[i,j]^.couleurs of
	      1	: TextColor(blue);
	      2	: TextColor(red);
	      3	: TextColor(green);
	      4	: TextColor(cyan);
	      5	: TextColor(yellow);
	      6	: TextColor(magenta);
	    End;
	    Case grille[i,j]^.formes of
	      1	: write(' C ');
	      2	: write(' O ');
	      3	: write(' X ');
	      4	: write(' H ');
	      5	: write(' W ');
	      6	: write(' S ');
	    End;
	    TextColor(White);
	 End;
      End;
      if i>0 then
	 begin
	    c2:=c2+1;
	 end;
      writeln();
   End;
END;

(*=================================Pour Initialiser=================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : creerPiece
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : creer une piece pour le jeu
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function creerPiece(couleurs,formes : Integer):ptr_piece;
VAR
   tuile :ptr_piece;

Begin
   new(tuile);
   tuile^.formes:=formes;
   tuile^.couleurs:=couleurs;
   tuile^.suivant:=Nil;
   creerPiece:=tuile;
End;

(*==================================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : ajoutpos
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : ajoute a une position donner dans une liste
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function ajoutPos(l : ptr_piece; p,couleurs,formes:Integer):ptr_piece;
VAR
   tuiles,res : ptr_piece;
   
Begin
   if (p=0)  then
   Begin
      new(tuiles);
      tuiles^.couleurs:=couleurs;
      tuiles^.formes:=formes;
      tuiles^.suivant:=l;
      res:=tuiles;
   End
   Else
   Begin
      l^.suivant:=ajoutPos(l^.suivant,p-1,couleurs,formes);
      res:=l;
   End;
   ajoutPos:=res;
End;

(*==================================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : initpioche
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : initialise notre pioche aleatoirement
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function initpioche(nbid,nbcoul,nbfor :Integer ):ptr_piece;
Var
   k,i,j,nbt,p : integer;
   tuile,pioche : ptr_piece;
BEGIN
   nbt:=1;
   pioche:=Nil;
   for k:=0 to nbid do
   begin
      for i:=1 to nbcoul do
      begin
	 for j:=1 to nbfor do
	 begin
	    tuile:=creerPiece(i,j);
	    if (nbt<=(nbid*nbcoul*nbfor)) then
	    Begin
	       p:=Random(nbt);
	       nbt:=nbt+1;
	       pioche:=ajoutPos(pioche,p,tuile^.couleurs,tuile^.formes);
	       initpioche:=pioche;
	    End;
	 end;
      end;
   end;
END;
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : affiche pos
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : affiche le spositions sous la main
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Procedure affichepos(main : ptr_piece);
VAR
   c : Integer;

Begin
   c:=0;
   writeln();
   While (main<>Nil) do
   Begin
      write(' ');
      write(c,' |' );
      c:=c+1;
      main:=main^.suivant;
   End;
End;


(*===================================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : creerMain
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : creer notre main pour un seul joueur
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
Function creerMain(l : ptr_piece):typeMain;
VAR
   i	 : Integer;
   main	 : typeMain;
   n,tmp : ptr_piece;
Begin
   n:=l;
   For i:=0 to 4 do
   Begin
      l:=l^.suivant;
   end;
   tmp:=l^.suivant;
   l^.suivant:=NIL;
   main.pioche:=tmp;
   main.main:=n;
   creerMain:=main;
End;


(*==================================================================================================*)
(*
 ------------------------------------------------------------------------------------
 -- Fonction          : initGrille
 -- Auteur            : Charles DUC <duccharles@eisti.eu>
 -- Date de creation  : 12/12/17
 --
 -- But               : initialise notre grille
 -- Remarques         : Aucune
 -- Compilation       : fpc
 -- Edition des liens : fpc
 -- Execution         : shell
 ------------------------------------------------------------------------------------
 *)
FUNCTION initGrille(n :integer):typeGrille;
Var
   grille : typeGrille;
   i,j	  : Integer;
Begin
   setlength(grille,n+1,n+1);
   For i:=0 to n do
   begin
      for j:=0 to n do
      begin
	 grille[i,j]:=creerPiece(0,0);
      end;
   end;
   initGrille:=grille;
end;

(*=================================================================================================*)


END.		    
