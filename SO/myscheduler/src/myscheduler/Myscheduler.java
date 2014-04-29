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

/**
 *
 * @author positr0nix ( Irvin Castellanos Juárez )
 * gitHub:  gitHub.com/positr0nix
 * Clase:   Sistemas Operativos
 * grupo:   602
 * 
 */
public class Myscheduler {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        
        Process []procesos = new Process[10];
        MyQueue cola = new MyQueue();
        
        for ( int i=0; i<10; i++ )
        {
            cola.push( new Process(i+1,100) ); 
        }
        
        System.out.println( cola.getAt(9) );
        
        while( !cola.isEmpty() ){
            System.out.println( cola.front( ) );
            cola.pop( );
        }


    }
    
}
