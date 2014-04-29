/*
   This file is part of Myscheduler.

    Myscheduler is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Myscheduler is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.

 */

package myscheduler;

/*
 *
 * @author positr0nix ( Irvin Castellanos Juárez )
 * gitHub:  gitHub.com/positr0nix
 * Clase:   Sistemas Operativos
 * grupo:   602
 * 
 */

public class MyQueue {
    
    class Node{
        Process data;
        Node next;
    }

    Node root , last;
    int size ;
    
    public MyQueue( ){
        root = null;
        last = null;
        size = 0;
    }
    
    public boolean isEmpty( ){
        if( root == null )
            return true;
        return false;
    }
    
    public void push( Process value ){
        Node tmp  = new Node( );
        tmp.data = value;
        tmp.next = null;
        
        if( isEmpty() )
            root = tmp;
        else
            last.next = tmp;
        
        last = tmp;
        size++;
    }
    
    public Process front( ){
        if( isEmpty() )
            return null;
        return root.data;
    }
    
    
    public boolean pop( ){
        if( isEmpty() )
            return false;
        
        if( getSize() == 1 )
            last = root.next;
        
        Node tmp = root;
        root = root.next;
        
        tmp.next = null;
        tmp = null;
        
        size--;
        return true;
    }
    
    public int getSize( ){
        return this.size;
    }
    
    /* return a process in  a position select */ 
    public Process getAt( int n ){
        int index = 0;
        Node tmp  = root;
        while( !isEmpty() &&  index < getSize() ){
            if( index == n )
                return tmp.data;
            index++;
            tmp = tmp.next;
        }
        return null;
    }
}
