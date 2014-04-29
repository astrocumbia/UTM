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

public final class Process {
    
    private int     PID;          /* Process ID */
    private int     quantum;      
    private boolean punished;
    private boolean new_process;
    
    public Process( int _PID, int _quantum  ){
        setPID( _PID );
        setQuantum( _quantum );
        setNewProcess( true );
        setPunish( false );
    }
    
    /* a method for change the PID value*/
    private void setPID( int value ){
        this.PID = value > 0 ? value : 0;
    }
    
    public void setQuantum( int value ){
        this.quantum = value >  0 ? value : 0;
    }
    
    public void setNewProcess( boolean value ){
        this.new_process = value;
    }
    
    public void setPunish( boolean value ){
        this.punished = value;
    }
    
    public int getPID( ){
        return this.PID;
    }
    
    public int getQuantum( ){
        return this.quantum;
    }
    
    public boolean isNewProcess( ){
        return this.new_process;
    }
    
    public boolean isPunish( ){
        return this.punished;
    }
    
    @Override
    public String toString( ){
        return "I'm the process "+getPID()+". I have "+getQuantum( )+" quantums.";
    }
    
}
