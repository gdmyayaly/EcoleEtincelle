import { Component, OnDestroy, OnInit } from '@angular/core';
import { NiveauEtudeService } from '../../scolarite/niveauEtude/service/niveau-etude.service';
import { NiveauEtudeModel } from '../../scolarite/niveauEtude/model/niveauEtute';
import { ParentElevesModel } from '../../parentEleves/model/parentEleves';
import { ParentElevesService } from '../../parentEleves/service/parent-eleves.service';
import { AnneeScolaireModel } from '../../scolarite/anneeScolaire/model/anneeScolaire';
import { AnneeScolaireService } from '../../scolarite/anneeScolaire/service/niveau-etude.service';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ElevesService } from '../service/eleves.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-eleves-add',
  templateUrl: './eleves-add.component.html',
  styleUrls: ['./eleves-add.component.css']
})
export class ElevesAddComponent implements OnInit,OnDestroy{

  public listNiveuaEtude:NiveauEtudeModel[]=[];
  public listParentEleves:ParentElevesModel[]=[];
  public listAnneeScolaire:AnneeScolaireModel[]=[];
  public formAddEleves= new FormGroup({
    prenom : new FormControl('',Validators.required),
    nom : new FormControl('',Validators.required),
    age : new FormControl('',Validators.required),
    date : new FormControl('',Validators.required),
    sex : new FormControl('',Validators.required),
    niveauEtude : new FormControl('',Validators.required),
    parents : new FormControl('',Validators.required),
    commentaire : new FormControl(''),
    anneeScolaire : new FormControl('',Validators.required)
  })
  public ImageOneUpload:any;
  public imgUpload:string="";
  public defaultImg:string="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1361&q=80";
  
  constructor(private router:Router,private elevesService:ElevesService,private niveauEtudeServices:NiveauEtudeService,private parentService:ParentElevesService,private anneScolaireService:AnneeScolaireService){}
  ngOnInit(): void {
    this.imgUpload=this.defaultImg;
    this.loadAnneScolaire();
    this.loadNiveauEtude();
    this.loadParentEleves();
  }
  ngOnDestroy(): void {
    
  }
  loadNiveauEtude(){
    this.niveauEtudeServices.loadListEtude().subscribe(
      res=>{
        console.log("Niveau Etude");
        console.log(res);
        this.listNiveuaEtude=res;
      },
      error=>{console.log(error);
      }
    )
  }
  loadParentEleves(){
    this.parentService.listParentEleves().subscribe(
      res=>{
        console.log("Parent Eleves");
        console.log(res);
        this.listParentEleves=res;
      },
      error=>{console.log(error);
      }
    )
  }
  loadAnneScolaire(){
    this.anneScolaireService.loadListAnneeScolaire().subscribe(
      res=>{
        console.log("Année Scolaire");
        console.log(res);
        this.listAnneeScolaire=res;
      },
      error=>{console.log(error);
      }
    )
  }
  saveEleves(){
    console.log(this.formAddEleves.value);
    const formData:FormData = new FormData();
    let isUploadImg="false"
    if (this.imgUpload!=this.defaultImg) {
      formData.append("image",this.ImageOneUpload[0], this.ImageOneUpload[0].name);
      isUploadImg="true";
    }
    formData.append("isUpload",isUploadImg);
    formData.append("prenom",this.formAddEleves.get("prenom")?.value ?? "")
    formData.append("nom",this.formAddEleves.get("nom")?.value ?? "")
    formData.append("age",this.formAddEleves.get("age")?.value ?? "")
    formData.append("date",this.formAddEleves.get("date")?.value ?? "")
    formData.append("sex",this.formAddEleves.get("sex")?.value ?? "")
    formData.append("niveauEtude",this.formAddEleves.get("niveauEtude")?.value ?? "")
    formData.append("parents",this.formAddEleves.get("parents")?.value ?? "")
    formData.append("commentaire",this.formAddEleves.get("commentaire")?.value ?? "")
    formData.append("anneeScolaire",this.formAddEleves.get("anneeScolaire")?.value ?? "")
    console.log(formData.get('parents'));
    this.elevesService.saveEleves(formData).subscribe(
      res=>{
        console.log(res);
        this.formAddEleves.reset(); 
        this.router.navigateByUrl("/admin/eleves")
      },
      error=>{
        console.log(error);
        
      }
    )
  }
  handleOneFileInput(event:any){
    const fileList:FileList = event.target.files;
    this.ImageOneUpload=[];
    for (let index = 0; index < fileList.length; index++) {
      this.ImageOneUpload.push(fileList.item(index));
      const file = fileList[index];
      // const fileType = file.type.split('/')[0];
      const fileUrl = URL.createObjectURL(file);
      this.imgUpload=fileUrl;
    }
  }
}
