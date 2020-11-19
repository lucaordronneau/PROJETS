package fr.cyu.cyfight.game.base;

public class Case implements Comparable<Case> {
    public int x;
    public int y;
    public int distance;
    public Case parent;

    public Case(int x, int y, int distance, Case parent) {
        this.x = x;
        this.y = y;
        this.distance = distance;
        this.parent = parent;
    } 

    @Override
    public int compareTo(Case otherCase) {
    	return (this.compareTo(otherCase));
    }
    
    @Override
    public String toString(){
    	return "("+x+ ","+y+")";
    }
}